<?php

namespace Modules\Backend\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\One\TwitterProvider;
use Laravel\Socialite\Two\{
    AbstractProvider,
    BitbucketProvider,
    FacebookProvider,
    GithubProvider,
    GitlabProvider,
    GoogleProvider,
    LinkedInProvider,
    SlackProvider
};
use Modules\Backend\Events\RegistereSuccessfull;
use Modules\Backend\Models\SocialToken;
use Illuminate\Support\Str;
use Modules\Core\Models\User;

class SocialLoginController extends Controller
{


    public function redirectToProvider($provider)
    {
        $config = $this->getConfig($provider);

        return Socialite::driver($provider)->redirect();
    }


    public function handleProviderCallback($provider)
    {

        $user = $this->getProvider($provider)->user();
        $register = false;

        DB::beginTransaction();

        try {
            $user = $this->createOrUpdate($user, $provider, $register);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if ($register) {
            event(new RegistereSuccessfull($user));
        }

        Auth::login($user, true);

        return redirect()->route('admin.dashboard');
    }


    public function createOrUpdate($authUser, $provider, &$register)
    {
        $userToken = SocialToken::where('provider', $provider)
            ->where('social_id', $authUser->id)
            ->first();

        if ($userToken) {
            $userToken->update([
                'social_token' => $authUser->token,
                'social_refresh_token' => $authUser->refreshToken,
            ]);

            return $userToken->user;
        }

        $userExist = User::whereEmail($authUser->email)->first();

        if ($userExist) {
            $user = $this->updateSocialToken($userExist, $authUser, $provider);
            return $user;
        }

        $password = Str::random(8);

        $register = true;

        $user = new User();
        $user->fill(
            [
                'name' => $authUser->name,
                'email' => $authUser->email,
            ]
        );

        $user->setAttribute('password', Hash::make($password));
        $user->save();

        $this->updateSocialToken($user, $authUser, $provider);
    }

    protected function updateSocialToken(User $user, $authUser, $provider): User
    {
        return $user->socialTokens()->updateOrCreate(
            [
                'social_id' => $authUser->id,
                'social_provider' => $provider,
            ],
            [
                'social_token' => $authUser->token,
                'social_refresh_token' => $authUser->refreshToken,
            ]
        );
    }

    public function getProvider(string $provider): AbstractProvider
    {
        $config = $this->getConfig($provider);

        switch ($provider) {
            case 'github':
                $provider = GithubProvider::class;
                break;
            case 'gitlab':
                $provider = GitlabProvider::class;
                break;
            case 'google':
                $provider = GoogleProvider::class;
                break;
            case 'facebook':
                $provider = FacebookProvider::class;
                break;
            case 'twitter':
                $provider = TwitterProvider::class;
                break;
            case 'linkedin':
                $provider = LinkedInProvider::class;
                break;
            case 'bitbucket':
                $provider = BitbucketProvider::class;
                break;
            case 'slack':
                $provider = SlackProvider::class;
                break;
            default:
                abort(404);
        }

        return Socialite::buildProvider($provider, $config);
    }

    private function getConfig($provider): array
    {
        $config = Arr::get(get_config('socialites', []), $provider);

        if (empty($config['client_id']) || empty($config['client_secret']) || empty($config['enable'])) {
            abort(404);
        }

        return [
            'client_id' => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'redirect' => route('auth.social.callback', $provider)
        ];
    }
}
