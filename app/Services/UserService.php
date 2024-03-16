<?php
namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Contracts\UserAdditionalInfo;
use App\Models\User;

class UserService implements UserServiceInterface {
    public function findUser(string $id): User {
        return User::findOrFail($id);
    }

    public function updateAdditionalInfo(string $id, UserAdditionalInfo $info): bool {
        $user = $this->findUser($id);

        $user->breed = $info->breed;
        $user->age = $info->age;

        return $user->save();
    }
}