<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AuthServiceInterface;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function __construct(private readonly AuthServiceInterface $authService) {
    }

    public function logout() {
       return $this->authService->logout();
    }

    public function refresh() {
        return $this->authService->refresh();
    }
}
