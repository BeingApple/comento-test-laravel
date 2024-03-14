<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class KakaoLoginController extends Controller
{
    public function redirect() {
        return Socialite::driver('kakao')->redirect();
    }

    public function callback(Request $request) {
        $userInfo = Socialite::driver('kakao')->user();
        dump($userInfo);
        
    }
}
