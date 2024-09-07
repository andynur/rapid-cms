<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'Success',
        'data' => [
            'version' => '1.0',
            'title' => 'Rapid CMS API',
        ],
    ]);
});
