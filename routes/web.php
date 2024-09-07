<?php

use App\Helpers\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return JsonResponse::success([
        'version' => '1.0',
        'title' => 'Rapid CMS API',
    ]);
})->name('index');
