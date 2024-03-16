<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

use InvalidArgumentException;
use Laravel\Socialite\Two\InvalidStateException;

class SocialLoginController extends Controller
{
    // 소셜라이트를 이용한 소셜 로그인 연동
    public function redirect(string $type) {
        try {
            return Socialite::driver($type)->redirect();
        } catch (InvalidArgumentException $e) {
            return response()->error(400, "$type 은 지원하지 않는 소셜 로그인 방식입니다.");
        }
    }

    // 소셜라이트를 이용한 로그인 콜백
    public function callback(Request $request, string $type) {
        try {
            $socialInfo = Socialite::driver($type)->user();
            
            $social = Social::updateOrCreate([
                'type' => $type, 
                'social_id' => $socialInfo->id
            ], [
                'access_token' => $socialInfo->token,
                'refresh_token' => $socialInfo->refreshToken
            ]);

            $user = User::updateOrCreate([
                'email' => $socialInfo->email,
            ], [
                'name' => $socialInfo->nickname
            ]);

            $user->socials()->save($social);
            
            Auth::login($user);
        } catch (InvalidStateException $e) {
            // 로그인 상태가 잘못된 경우 로그인을 처리할 수 있도록 소셜 로그인 페이지로 이동
            return redirect("/social/$type/login");
        } catch (InvalidArgumentException $e) {
            return response()->error(400, "$type 은 지원하지 않는 소셜 로그인 방식입니다.");
        }
    }
}
