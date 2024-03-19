<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\ServiceServiceProvider::class,
    SocialiteProviders\Manager\ServiceProvider::class,
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
    L5Swagger\L5SwaggerServiceProvider::class,
];
