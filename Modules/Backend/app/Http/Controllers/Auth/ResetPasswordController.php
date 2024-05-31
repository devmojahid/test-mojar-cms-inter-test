<?php

namespace Modules\Backend\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Backend\Http\Requests\ResetPasswordRequest;
use Modules\Backend\Services\ResetPasswordService;
use Modules\Core\Traits\ResponseMessage;

class ResetPasswordController extends Controller
{
    use ResponseMessage;

    public function resetPassword($email, $token)
    {
        return view('backend::auth.reset_password', compact('email', 'token'));
    }

    public function reset(ResetPasswordRequest $request, $email, $token, ResetPasswordService $resetPasswordService)
    {
        $responseRaw = $resetPasswordService->resetPassword($request->validated(), $email, $token);
        $response = $responseRaw->getData(true);
        if ($response['status']) {
            return $this->success(
                [
                    'redirect' => $response['data']['redirect'],
                    'message' => $response['data']['message']
                ]
            );
        }

        return $this->error(
            [
                'message' => $response['data']['message']
            ]
        );
    }
}
