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

class ResetPasswordService
{
    use ResponseMessage;
    public function resetPassword($data, $email, $token)
    {
        // Register user
        do_action('reset_password.handle', $data);

        $passwordReset = PasswordReset::where('email', $email)
            ->where('token', $token)
            ->firstOrFail();

        $user = User::whereEmail($passwordReset->email)->firstOrFail();

        DB::beginTransaction();

        try {
            $user->password = Hash::make($data['password']);
            $user->save();

            $passwordReset->delete();

            DB::commit();

            do_action('reset_password.success', $user);

            return $this->success(
                [
                    'redirect' => route('admin.login'),
                    'message' => 'Password reset successfully'
                ]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            do_action('reset_password.failed', $user);
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
