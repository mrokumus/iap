<?php

use Illuminate\Support\Facades\Route;


//Api Routes
Route::post('register/{uid}/{os}/{language}/{clientToken?}', [\App\Http\Controllers\Api\RegisterController::class, 'register']);
Route::post('purchase', [\App\Http\Controllers\Api\PurchaseController::class, 'purchase']);
Route::post('check', [\App\Http\Controllers\Api\CheckSubscriptionController::class, 'checkSubscription']);

//Android Route
Route::get('android/{receipt}', [\App\Http\Controllers\Api\Android\AndroidController::class, 'check']);

//Ios Route
Route::get('ios', [\App\Http\Controllers\Api\Ios\IosController::class, 'check']);
