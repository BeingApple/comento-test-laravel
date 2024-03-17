<?php

namespace App\Providers;

use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\QuestionServiceInterface;
use App\Contracts\Services\SocialServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Services\AuthService;
use App\Services\QuestionService;
use App\Services\SocialService;
use App\Services\UserService;
use Illuminate\Foundation\Application;
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

        $this->app->bind(
            UserServiceInterface::class,
            UserService::class,
        );

        $this->app->bind(
            QuestionServiceInterface::class,
            QuestionService::class,
        );
    }
}
