<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 공통 응답을 생성하기 위한 Response macro 를 등록합니다.
        Response::macro('base', function(bool $result, string $message, object $value = NULL) {
            return Response::json(['result' => $result, 'message' => $message, 'data' => $value]);
        });
        Response::macro('error', function(int $status, string $message = "") {
            return Response::json(['message' => $message], $status);
        });
    }
}
