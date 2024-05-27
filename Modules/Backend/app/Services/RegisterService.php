<?php

namespace Modules\Backend\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Models\User;

class RegisterService
{
    public function register($data)
    {
        // Register user
        do_action('register.handle', $data);
        $password = $data['password'];

        DB::beginTransaction();

        try {
            $user = new User();

            $user->fill(
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                ]
            );

            $user->setAttribute('password', Hash::make($password));
            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        do_action('register.success', $user);

        return $user;
    }
}