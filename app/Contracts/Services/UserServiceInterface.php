<?php

namespace App\Contracts\Services;

use App\Contracts\UserAdditionalInfo;
use App\Contracts\UserType;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface UserServiceInterface {
    /**
     * @param string $id
     * @return User
     * @throws NotFoundHttpException
     */
    public function findUser(string $id): User;

    /**
     * @param string $id
     * @param UserAdditionalInfo $info
     * @return bool
     * @throws NotFoundHttpException
     */
    public function updateAdditionalInfo(string $id, UserAdditionalInfo $info): bool;

    /**
     * @param string $id
     * @param UserType $type
     * @return bool
     * @throws NotFoundHttpException
     */
    public function updateUserType(string $id, UserType $type): bool;
}