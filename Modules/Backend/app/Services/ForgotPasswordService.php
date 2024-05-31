<?php

namespace Modules\Backend\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Core\Emails\SendPasswordResetEmail;
use Modules\Core\Models\PasswordReset;
use Modules\Core\Models\User;
use Modules\Core\Traits\ResponseMessage;
use Illuminate\Support\Str;

class ForgotPasswordService
{
    use ResponseMessage;
    public function forgotPassword($data)
    {
        // Register user
        do_action('forgot_password.handle', $data);

        $email = $data['email'];

        $user = User::where('email', $email)
            ->where('status', User::STATUS_ACTIVE)
            ->first();

        if (!$user) {
            return $this->error(
                [
                    'message' => 'User not found'
                ]
            );
        }

        $existingToken = PasswordReset::where('email', $email)->first();

        if ($existingToken) {
            if ($existingToken->created_at < now()->subHour()) {
                // send email with old token
                do_action('forgot_password.old_token_send', $user);
                // SendPasswordResetEmail::dispatch($user, $existingToken->token);
                Mail::to($user->email)->send(new SendPasswordResetEmail($user->email, $user, $existingToken->token));
            }
        }


        DB::beginTransaction();

        try {
            $token = Str::random(32);
            $passwordReset = PasswordReset::updateOrCreate(
                ['email' => $email],
                [
                    'email' => $email,
                    'token' => $token
                ]
            );

            if ($passwordReset) {
                Mail::to($user->email)->send(new SendPasswordResetEmail($user->email, $user, $token));
            }

            DB::commit();
            do_action('forgot_password.success', $user);

            return $this->success(
                [
                    'message' => 'Password reset link sent to your email'
                ]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            do_action('forgot_password.failed', $user);
            return $this->error(
                [
                    'message' => 'Password reset failed'
                ]
            );
        }



        do_action('register.failed', $user);
        return $this->error(
            [
                'message' => 'Login failed'
            ]
        );
    }
}
