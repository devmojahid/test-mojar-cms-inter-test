<?php

namespace Modules\Backend\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Models\User;
use Modules\Core\Traits\ResponseMessage;

class LoginService
{
    use ResponseMessage;
    public function login($data)
    {
        // Register user
        do_action('login.handle', $data);

        $email = $data['email'];
        $password = $data['password'];

        $remember = filter_var($data['remember'] ?? 1, FILTER_VALIDATE_BOOLEAN);

        $user = User::whereEmail($email)->first('status', 'is_admin');

        if (empty($user)) {
            return $this->error(
                [
                    'message' => 'Email or password is incorrect'
                ]
            );
        }

        if ($user->status != "active") {
            if ($user->status == "verification") {
                return $this->error(
                    [
                        'message' => 'Please verify your email'
                    ]
                );
            }

            return $this->error(
                [
                    'message' => 'Your account has been suspended'
                ]
            );
        }


        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            return $this->success(
                [
                    'redirect' => route('admin.dashboard'),
                    'message' => 'Login successfully'
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
