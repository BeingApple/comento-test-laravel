<?php

namespace App\Providers;

use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\SocialServiceInterface;
use App\Services\AuthService;
use App\Services\SocialService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(
            SocialServiceInterface::class,
            SocialService::class,
        );

        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class,
        );
    }
}
