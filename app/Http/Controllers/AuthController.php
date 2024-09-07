<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Helpers\JsonResponse;
use App\Http\Resources\AuthResource;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->toData());

        return JsonResponse::created(new AuthResource($result), 'User registered successfully');
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->toData());
        if (!$result) {
            return JsonResponse::unauthorized('Invalid credentials');
        }

        return JsonResponse::success(new AuthResource($result), 'Login successful');
    }

    public function logout()
    {
        $this->authService->logout();

        return JsonResponse::success(null, 'Successfully logged out');
    }
}
