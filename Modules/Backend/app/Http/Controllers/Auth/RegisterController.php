<?php

namespace Modules\Backend\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Backend\Http\Requests\RegisterRequest;
use Modules\Backend\Services\RegisterService;
use Modules\Core\Traits\ResponseMessage;

class RegisterController extends Controller
{
    use ResponseMessage;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend::auth.register');
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
    public function store(RegisterRequest $request, RegisterService $registerService)
    {
        $registerService->register($request->validated());

        if (get_config('user_verification')) {
            return $this->success(
                [
                    'redirect' => route('admin.login'),
                    'message' => 'Register successfully, please check your email to verify your account'
                ]
            );
        }

        return $this->success(
            [
                'redirect' => route('admin.login'),
                'message' => 'Register successfully'
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
