<?php

namespace App\Services;

use App\Data\LoginData;
use App\Data\RegisterData;
use App\Events\UserRegistered;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterData $reqData)
    {
        // hash the password and save the user
        $user = $this->userRepository->create([
            'name' => $reqData->name,
            'email' => $reqData->email,
            'password' => Hash::make($reqData->password),
        ]);

        // generate api token
        $token = $user->createToken('api-token')->plainTextToken;
        $user->setAttribute('token', $token);

        // call event to send mail
        event(new UserRegistered($user));

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
