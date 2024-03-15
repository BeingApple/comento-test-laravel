<?php

use App\Http\Controllers\SocialLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/social/{type}/login', [SocialLoginController::class, 'redirect']);
Route::get('/social/{type}/callback', [SocialLoginController::class, 'callback']);