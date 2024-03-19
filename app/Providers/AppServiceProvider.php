<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use OpenApi\Annotations as OA;

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
        Response::macro('base', function(bool $result, string $message, object|array $value = NULL, int $status = 200) {
            return Response::json((array) new BaseReponse($result, $message, $value), $status);
        });
        Response::macro('error', function(int $status, string $message = "") {
            return Response::json((array) new BaseReponse(false, $message), $status);
        });
    }
}

/**
 * @OA\Schema(
 *     description="공통 응답 모델",
 *     title="BaseResponse",
 *     required={"result", "message"},
 *     schema="BaseResponse"
 * )
 */
class BaseReponse {
    /**
     * @OA\Property(
     *     type="boolean",
     *     format="boolean",
     *     description="응답 결과",
     * )
     */
    public bool $result;

    /**
     * @OA\Property(
     *     type="string",
     *     format="string",
     *     description="응답 메세지",
     * )
     */
    public string $message;

    /**
     * @OA\Property(
     *     type="object",
     *     description="응답",
     * )
     */
    public object|array $value;

    public function __construct(bool $result, string $message, object|array $value = []) {
        $this->result = $result;
        $this->message = $message;
        $this->value = $value;
    }
}
