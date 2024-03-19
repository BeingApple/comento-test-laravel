<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SocialServiceInterface;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

use InvalidArgumentException;
use Laravel\Socialite\Two\InvalidStateException;

use OpenApi\Annotations as OA;

class SocialLoginController extends Controller
{
    public function __construct(protected SocialServiceInterface $socialService) {
    }

    // 소셜라이트를 이용한 소셜 로그인 연동
    /**
     *
     * @OA\Get(
     *     path="/social/{type}/login",
     *     summary="소셜 로그인",
     *     description="OAuth에 기반한 써드파티 로그인 창을 오픈합니다. 브라우저를 통해 직접 접속해야 합니다. 
     *          <br />현재는 인증 완료 후 발급된 Access Token과 redirection 파라메터를 함께 요청한 경우 해당 값을 쿼리 파라메터로 담아 코멘토 홈페이지로 이동시킵니다.
     *          <br />프론트엔드 페이지가 라라벨 내부로 들어오게 되면 Route를 통해 파라메터를 넘기거나, 세션이나 쿠키 등으로 별도로 처리할 수 있을 거 같습니다. 
     *          <br />**접속 URL:** [http://localhost:8000/social/kakao/login](http://localhost:8000/social/kakao/login)" ,
     *     tags={"인증"},
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         description="인증에 활용하고자 하는 소셜 로그인 제공자 종류입니다. 설정을 추가함에 따라 원하는 써드파티를 쉽게 추가할 수 있습니다.",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="kakao",
     *             enum={"kakao"}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="redirection",
     *         in="query",
     *         description="인증 완료 후 리디렉션 될 페이지에서 되돌려 주는 값입니다. 리디렉션이 필요한 경우 활용하면 됩니다.",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="요청한 소셜 로그인 제공자로 정상적으로 이동처리 되었습니다."
     *     ),
     * )
     */
    public function redirect(Request $request, string $type) {
        try {
            // query param으로 넘겨받은 redirection 값 불러오기
            $redirection = $request->query("redirection");

            return $this->socialService->redirect($type, $redirection);
        } catch (InvalidArgumentException $e) {
            return response()->error(Response::HTTP_BAD_REQUEST, "$type 은 지원하지 않는 소셜 로그인 방식입니다.");
        }
    }

    // 소셜라이트를 이용한 로그인 콜백
    /**
     *
     * @OA\Get(
     *     path="/social/{type}/callback",
     *     summary="소셜 로그인 콜백",
     *     description="OAuth에 기반한 써드파티 로그인 후 써드파티 서비스가 쿼리 파라메터와 함께 리디렉션 할 페이지입니다.",
     *     tags={"인증"},
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         description="인가 코드입니다.",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="state",
     *         in="query",
     *         description="요청을 식별할 수 있는 상태코드입니다.",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Access Token과 redirection 파라메터를 함께 요청한 경우 해당 값을 쿼리 파라메터로 담아 코멘토 홈페이지로 이동되었습니다."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="지원하지 않는 소셜 로그인 제공자입니다.",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/BaseResponse",
     *             example = {"result" : "false", "message" : "naver 은 지원하지 않는 소셜 로그인 방식입니다.", "value" : {}}
     *         ),
     *     ),
     * )
     */
    public function callback(Request $request, string $type) {
        try {
            $socialInfo = Socialite::driver($type)->user();
            $user = $this->socialService->saveUser($type, $socialInfo);

            // redirection 있는지 확인
            $state = $request->query("state");
            $redirection = $this->socialService->getStateRedirection($state);

            // JWT 생성하기
            $token = auth()->login($user);

            // 리디렉션, accessToken 등 인증 정보와 함께 프론트엔드가 처리할 수 있는 페이지로 반환
            $query = Arr::query([
                'redirection' => $redirection,
                'access_token' => $token,
            ]);

            return redirect("https://comento.kr/job-questions?$query");
        } catch (InvalidStateException $e) {
            // 로그인 상태가 잘못된 경우 로그인을 처리할 수 있도록 소셜 로그인 페이지로 이동
            return redirect("/social/$type/login");
        } catch (InvalidArgumentException $e) {
            return response()->error(Response::HTTP_BAD_REQUEST, "$type 은 지원하지 않는 소셜 로그인 방식입니다.");
        }
    }
}
