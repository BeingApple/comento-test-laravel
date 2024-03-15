<?php

namespace App\Http\Controllers;

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
            $social = Socialite::driver($type)->user();
            
            //TODO 추후에 유저 : 소셜 = 1 : N 관계를 구축할 수 있도록 변경
            $user = User::updateOrCreate([
                'social_id' => $social->id,
            ], [
                'name' => $social->nickname,
                'social_id' => $social->id,
                'access_token' => $social->token,
                'refresh_token' => $social->refreshToken
            ]);
            
            Auth::login($user);
        } catch (InvalidStateException $e) {
            // 로그인 상태가 잘못된 경우 로그인을 처리할 수 있도록 소셜 로그인 페이지로 이동
            return redirect("/social/$type/login");
        } catch (InvalidArgumentException $e) {
            return response()->error(400, "$type 은 지원하지 않는 소셜 로그인 방식입니다.");
        }
    }
}
