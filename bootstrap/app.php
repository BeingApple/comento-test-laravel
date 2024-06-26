<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: '',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return response()->error(Response::HTTP_UNAUTHORIZED, "로그인이 필요합니다.");
        });

        $exceptions->render(function (BadRequestException $e, Request $request) {
            return response()->error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->error(Response::HTTP_NOT_FOUND, $e->getMessage());
        });
    })->create();
