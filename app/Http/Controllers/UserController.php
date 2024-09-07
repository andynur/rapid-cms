<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Helpers\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(int $id)
    {
        // Cache key for user detail
        $cacheKey = 'user_' . $id;

        // Try to get user from cache
        $user = Cache::remember($cacheKey, 60 * 60, function () use ($id) {
            return $this->userService->findUserById($id);
        });

        return JsonResponse::success(new UserResource($user), 'User retrieved successfully');
    }
}
