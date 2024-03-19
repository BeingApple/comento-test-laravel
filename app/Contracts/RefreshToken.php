<?php

namespace App\Contracts;

// 갱신된 토큰 정보 반환시 사용되는 payload
/**
 * @OA\Schema(
 *     description="갱신 토큰 모델",
 *     title="RefreshToken",
 *     schema="RefreshToken"
 * )
 */
class RefreshToken {
    /**
     * @OA\Property(
     *     format="string",
     *     description="갱신된 토큰",
     *     type="string",
     * )
     */
    public string $access_token;

    /**
     * @OA\Property(
     *     format="string",
     *     description="토큰 유형",
     *     type="string",
     * )
     */
    public string $token_type;

    /**
     * @OA\Property(
     *     format="int",
     *     description="만료일자",
     *     type="int",
     * )
     */
    public int $expires_in;

    public function __construct(string $access_token, string $token_type, int $expires_in) {
        $this->access_token = $access_token;
        $this->token_type = $token_type;
        $this->expires_in = $expires_in;
    }
}