<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// set all response to api group as a json
app('request')->headers->set('Accept', 'application/json');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
