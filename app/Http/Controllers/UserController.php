<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Helpers\JsonResponse;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(User $user)
    {
        return JsonResponse::success(new UserResource($user), 'User retrieved successfully');
    }
}
