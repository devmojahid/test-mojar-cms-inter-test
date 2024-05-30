<?php

namespace Modules\Backend\Http\Controllers\Auth;

use Illuminate\Routing\Controller;

class ResetPasswordController extends Controller
{
    public function resetPassword($rmail, $token)
    {
        dd($rmail, $token);
        // return view('backend::auth.reset_password', compact('rmail', 'token'));
    }
}
