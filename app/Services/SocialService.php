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
    protected function saveState(string $state, string $redirection = NULL): void {
        if (!empty($state) && !empty($redirection)) {
            // state 와 redirection 값이 존재하면 저장하여 콜백에서 재사용
            SocialState::create([
                'state' => $state,
                'redirection' => $redirection
            ]);
        }
    }

    public function redirect(string $type, string $redirection = NULL): RedirectResponse {
        $response = Socialite::driver($type)->redirect();
        $parseUrl = parse_url($response->getTargetUrl());
        parse_str($parseUrl['query'], $query);

        $state = $query['state'];
        $this->saveState($state, $redirection);

        return $response;
    }

    public function saveUser(string $type, SocialUser $socialInfo): User {
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

        return $user;
    }

    public function getStateRedirection(string $state): ?string {
        $socialState = SocialState::firstWhere('state', $state);

        // 존재하면 리디렉션 반환하고 데이터 삭제처리
        if(isset($socialState)) {
            $redirection = $socialState->redirection;
            $socialState->delete();

            return $redirection;
        }

        return NULL;
    }
}