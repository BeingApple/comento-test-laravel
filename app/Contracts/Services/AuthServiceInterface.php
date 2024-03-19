<?php

namespace App\Contracts\Services;

use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;

interface AuthServiceInterface {
    /**
     * @return Response
     * @throws AuthenticationException
     */
    public function logout(): Response;

    /**
     * @return Response
     * @throws AuthenticationException
     */
    public function refresh(): Response;

}