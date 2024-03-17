<?php

namespace App\Services;

use App\Contracts\Services\SocialServiceInterface;
use App\Models\Social;
use App\Models\SocialState;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialUser;
use App\Models\User;

class SocialService implements SocialServiceInterface {
    protected function saveState(string $state, string $redirection): void {
        // state 와 redirection 값이 존재하면 저장하여 추후 콜백에서 재사용
        SocialState::create([
            'state' => $state,
            'redirection' => $redirection
        ]);
    }

    public function redirect(string $type, string $redirection = NULL): RedirectResponse {
        // 생성된 소셜 리디렉션 링크를 생성하여 반환 
        $response = Socialite::driver($type)->redirect();
        $parseUrl = parse_url($response->getTargetUrl());
        parse_str($parseUrl['query'], $query);

        // 리디렉션 링크에 oauth state 값, 넘겨 받은 리디렉션 링크가 있으면 별도로 저장
        $state = $query['state'];
        if (!empty($state) && !empty($redirection)) {
            $this->saveState($state, $redirection);
        }

        return $response;
    }

    public function saveUser(string $type, SocialUser $socialInfo): User {
        // SNS 유형과 식별자로 찾은 뒤 업데이트 하거나 새로 생성합니다.
        $social = Social::updateOrCreate([
            'type' => $type, 
            'social_id' => $socialInfo->id
        ], [
            'access_token' => $socialInfo->token,
            'refresh_token' => $socialInfo->refreshToken
        ]);

        // 이메일을 기준으로 회원을 찾거나 새로 생성합니다.
        $user = User::updateOrCreate([
            'email' => $socialInfo->email,
        ], [
            'name' => $socialInfo->nickname
        ]);

        // 소셜 가입 정보를 회원 정보의 관계를 정의합니다.
        $user->socials()->save($social);

        return $user;
    }

    public function getStateRedirection(string $state): ?string {
        $socialState = SocialState::firstWhere('state', $state);

        // 존재하면 리디렉션할 링크 반환하고 데이터 삭제처리
        if(isset($socialState)) {
            $redirection = $socialState->redirection;
            $socialState->delete();

            return $redirection;
        }

        return NULL;
    }
}