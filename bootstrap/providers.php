<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\ServiceServiceProvider::class,
    SocialiteProviders\Manager\ServiceProvider::class,
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
];
