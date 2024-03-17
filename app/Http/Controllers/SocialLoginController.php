<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SocialServiceInterface;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

use InvalidArgumentException;
use Laravel\Socialite\Two\InvalidStateException;

class SocialLoginController extends Controller
{
    public function __construct(protected SocialServiceInterface $socialService) {
    }

    // 소셜라이트를 이용한 소셜 로그인 연동
    public function redirect(Request $request, string $type) {
        try {
            // query param으로 넘겨받은 redirection 값 불러오기
            $redirection = $request->query("redirection");

            return $this->socialService->redirect($type, $redirection);
        } catch (InvalidArgumentException $e) {
            return response()->error(Response::HTTP_BAD_REQUEST, "$type 은 지원하지 않는 소셜 로그인 방식입니다.");
        }
    }

    // 소셜라이트를 이용한 로그인 콜백
    public function callback(Request $request, string $type) {
        try {
            $socialInfo = Socialite::driver($type)->user();
            $user = $this->socialService->saveUser($type, $socialInfo);

            // redirection 있는지 확인
            $state = $request->query("state");
            $redirection = $this->socialService->getStateRedirection($state);

            // JWT 생성하기
            $token = auth()->login($user);

            // 리디렉션, accessToken 등 인증 정보와 함께 프론트엔드가 처리할 수 있는 페이지로 반환
            $query = Arr::query([
                'redirection' => $redirection,
                'access_token' => $token,
            ]);

            return redirect("https://comento.kr/job-questions?$query");
        } catch (InvalidStateException $e) {
            // 로그인 상태가 잘못된 경우 로그인을 처리할 수 있도록 소셜 로그인 페이지로 이동
            return redirect("/social/$type/login");
        } catch (InvalidArgumentException $e) {
            return response()->error(Response::HTTP_BAD_REQUEST, "$type 은 지원하지 않는 소셜 로그인 방식입니다.");
        }
    }
}
