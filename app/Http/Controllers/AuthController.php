<?php

namespace app\Http\Controllers;

use app\Http\Requests\LoginRequest;
use app\Http\Requests\RegisterRequest;
use app\Http\Requests\UpdatePasswordRequest;
use app\Services\AuthService;
use app\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ResponseTrait;
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(RegisterRequest $request)
    {
        return $this->returnData(__("messages.you are registered for early access or we will get in touch with you shortly once the App is released."),
            201,
            $this->authService->register($request));
    }
    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }
 
    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return $this->success(__('messages.Logged Out Successfully'), 200);
    }

    public function renewPassword(UpdatePasswordRequest $request)
    {
        $email = $request->user()->email;
        return $this->authService->updateoldPassword(
            $email,
            $request->old_password,
            $request->new_password
        );
    }



}
