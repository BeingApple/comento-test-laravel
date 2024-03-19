<?php

namespace App\Services;

use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\RefreshToken;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthService implements AuthServiceInterface {
    public function logout(): Response {
        Auth::logout(true);

        return response()->base(true, "로그아웃 되었습니다.");
    }

    protected function respondWithToken($token): Response {
        return response()->base(
            true, 
            "갱신되었습니다.", 
            new RefreshToken($token, 'bearer', Auth::factory()->getTTL() * 60)
        );
    }

    public function refresh(): Response {
        $refreshToken = Auth::refresh();
        Auth::logout(true);
        return $this->respondWithToken($refreshToken);
    }
}