<?php

namespace App\Services;

use App\Data\LoginData;
use App\Data\RegisterData;

interface AuthServiceInterface
{
    public function register(RegisterData $reqData);

    public function login(LoginData $credentials);

    public function logout();
}
