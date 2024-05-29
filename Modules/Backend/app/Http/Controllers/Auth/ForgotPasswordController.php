<?php

namespace Modules\Backend\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Backend\Http\Requests\ForgotPasswordRequest;
use Modules\Backend\Services\ForgotPasswordService;
use Modules\Core\Traits\ResponseMessage;

class ForgotPasswordController extends Controller
{
    use ResponseMessage;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend::auth.forgot_password');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ForgotPasswordRequest $request, ForgotPasswordService $forgotPasswordService)
    {
        $responseRaw = $forgotPasswordService->forgotPassword($request->validated());
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

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('backend::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('backend::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
