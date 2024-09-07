<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// set all response to api group as a json
app('request')->headers->set('Accept', 'application/json');

// auth routes
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::group(['middleware' => ['auth:sanctum']], function () {
    // auth logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');;

    // get a specific user by id
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

    // post routes with api resources
    Route::apiResource('posts', PostController::class);
});

// add comment api
Route::post('/posts/{post}/comments', [PostController::class, 'comment'])->name('posts.comment');
