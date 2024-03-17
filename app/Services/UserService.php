<?php
namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Contracts\UserAdditionalInfo;
use App\Contracts\UserType;
use App\Models\User;

class UserService implements UserServiceInterface {
    public function findUser(string $id): User {
        return User::findOrFail($id);
    }

    public function updateAdditionalInfo(string $id, UserAdditionalInfo $info): bool {
        // 유저의 품종, 나이 정보를 추가로 업데이트 합니다.
        $user = $this->findUser($id);

        $user->breed = $info->breed;
        $user->age = $info->age;

        return $user->save();
    }

    public function updateUserType(string $id, UserType $type): bool {
        // 유저의 멘토, 멘티 타입을 업데이트 합니다.
        $user = $this->findUser($id);

        $user->type = $type;

        return $user->save();
    }
}