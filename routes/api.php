<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user',function (Request $request) {
    return $request->user();
});

Route::post('register', [\App\Http\Controllers\Api\RegisterController::class, 'register']);
