<?php

namespace App\Contracts;

// 갱신된 토큰 정보 반환시 사용되는 payload
class RefreshToken {
    public string $access_token;
    public string $token_type;
    public int $expires_in;

    public function __construct(string $access_token, string $token_type, int $expires_in) {
        $this->access_token = $access_token;
        $this->token_type = $token_type;
        $this->expires_in = $expires_in;
    }
}