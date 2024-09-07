<?php

namespace App\Services;

use App\Data\LoginData;
use App\Data\RegisterData;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterData $reqData)
    {
        // Hash the password and save the user
        $user = $this->userRepository->create([
            'name' => $reqData->name,
            'email' => $reqData->email,
            'password' => Hash::make($reqData->password),
        ]);

        // Generate API token
        $token = $user->createToken('api-token')->plainTextToken;
        $user->setAttribute('token', $token);

        return $user;
    }

    public function login(LoginData $credentials)
    {
        if (!Auth::attempt($credentials->toArray())) {
            return null; // Return null if authentication fails
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;
        $user->setAttribute('token', $token);

        return $user;
    }

    public function logout()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
    }
}
