<?php

namespace App\Contracts;

// 유저의 추가 정보 변경 시 사용되는 payload
class UserAdditionalInfo {
    public string $breed;
    public int $age;

    public function __construct(string $breed, int $age) {
        $this->breed = $breed;
        $this->age = $age;
    }
}