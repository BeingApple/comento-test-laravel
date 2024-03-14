<?php

use App\Http\Controllers\KakaoLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/kakao/login', [KakaoLoginController::class, 'redirect']);
Route::get('/kakao/callback', [KakaoLoginController::class, 'callback']);