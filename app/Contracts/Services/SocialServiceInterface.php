<?php

namespace App\Contracts\Services;

use Illuminate\Http\RedirectResponse;
use InvalidArgumentException;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Contracts\User as SocialUser;
use App\Models\User;

interface SocialServiceInterface {
    /**
     * @param string $type
     * @param string $redirection
     * @return RedirectResponse
     * @throws InvalidArgumentException
     */
    public function redirect(string $type, string $redirection = NULL): RedirectResponse;

    /**
     * @param string $type
     * @param SocialUser $socialInfo
     * @return User
     * @throws InvalidStateException
     * @throws InvalidArgumentException
     */
    public function saveUser(string $type, SocialUser $socialInfo): User;

    /**
     * @param string $state
     * @return string
     */
    public function getStateRedirection(string $state): ?string;
}