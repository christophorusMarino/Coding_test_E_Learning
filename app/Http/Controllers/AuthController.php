<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\Auth\FormRequestAuth;
use App\Http\Requests\Auth\FormRequestUser;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function register(FormRequestUser $request)
    {
        $user = $this->authService->register($request->validated());

        return ApiResponseClass::successResponse($user, 'Success');
    }

    public function login(FormRequestAuth $request)
    {
        $result = $this->authService->login($request->validated());

        return ApiResponseClass::successResponse($result, 'Success');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return ApiResponseClass::successResponse('Logout', 'Success');
    }
}
