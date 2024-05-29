<?php

namespace Modules\Backend\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Models\User;
use Modules\Core\Traits\ResponseMessage;

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




        do_action('register.failed', $user);
        return $this->error(
            [
                'message' => 'Login failed'
            ]
        );
    }
}