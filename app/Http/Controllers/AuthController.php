<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AuthServiceInterface;
use Illuminate\Routing\Controller;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    public function __construct(protected AuthServiceInterface $authService) {
    }

    /**
     *
     * @OA\Post(
     *     path="/logout",
     *     summary="로그아웃",
     *     tags={"인증"},
     *     @OA\Response(
     *         response=200,
     *         description="성공적으로 로그아웃되어 토큰이 폐기되었습니다.",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/BaseResponse", 
     *             example = {"result" : "true", "message" : "로그아웃 되었습니다.", "value" : {}}
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="인증 정보가 없는 상태의 요청입니다.",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/BaseResponse",
     *             example = {"result" : "false", "message" : "로그인이 필요합니다.", "value" : {}}
     *         ),
     *     ),
     *     security={{
     *         "bearer-key":{}
     *     }},
     * )
     */
    public function logout() {
       return $this->authService->logout();
    }

    /**
     *
     * @OA\Post(
     *     path="/refresh",
     *     summary="토큰 갱신",
     *     tags={"인증"},
     *     @OA\Response(
     *         response=200,
     *         description="성공적으로 갱신되어 새로운 토큰이 발급되었습니다.",
     *         @OA\JsonContent(
     *             schema=@OA\Schema(
     *                 schema="",
     *                 allOf = {@OA\Schema(ref="#/components/schemas/BaseResponse")},
     *                 properties = {
     *                     "value" = @OA\Property(ref="#/components/schemas/RefreshToken")
     *                 }
     *             ),
     *             example = {
     *                 "result" : "true", 
     *                 "message" : "갱신되었습니다.", 
     *                 "value" : {
     *                     "access_token" : "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvcmVmcmVzaCIsImlhdCI6MTcxMDgyMDQ3NCwiZXhwIjoxNzEwODI0MDg1LCJuYmYiOjE3MTA4MjA0ODUsImp0aSI6IjZXYnZSMFhITTdiTjZYNWMiLCJzdWIiOiI5Yjk3NjIxMy0wZWMzLTQ2NTQtOTIyYS0xNDQxYTJjZTNjOTEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.VLQX1rc47jhptbgTbk8daOoRLbNi3dfap3KMIsZuTkk",
     *                     "type" : "bearer",
     *                     "expires_in" : 3600,
     *                 }
     *             }
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="인증 정보가 없는 상태의 요청입니다.",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/BaseResponse",
     *             example = {"result" : "false", "message" : "로그인이 필요합니다.", "value" : {}}
     *         ),
     *     ),
     *     security={{
     *         "bearer-key":{}
     *     }},
     * )
     */
    public function refresh() {
        return $this->authService->refresh();
    }
}
