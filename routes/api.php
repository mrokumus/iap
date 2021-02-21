<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user',function (Request $request) {
    return $request->user();
});

Route::post('register', [\App\Http\Controllers\Api\RegisterController::class, 'register']);
Route::post('purchase', [\App\Http\Controllers\Api\PurchaseController::class, 'purchase']);
Route::post('check-subscription', [\App\Http\Controllers\Api\CheckSubscriptionController::class, 'checkSubscription']);
