<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// 인증 관련 Routes
Route::middleware('auth:api')->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

// 유저 관련 Routes
Route::middleware('auth:api')->group(function() {
    Route::put('user/me', [UserController::class, 'updateAdditionalInfo']);
});