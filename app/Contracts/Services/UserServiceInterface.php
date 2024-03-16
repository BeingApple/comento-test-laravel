<?php

namespace App\Contracts\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Contracts\UserAdditionalInfo;
use App\Models\User;

interface UserServiceInterface {
    /**
     * @param string $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function findUser(string $id): User;

    /**
     * @param string $id
     * @param UserAdditionalInfo $info
     * @return bool
     * @throws ModelNotFoundException
     */
    public function updateAdditionalInfo(string $id, UserAdditionalInfo $info): bool;

}