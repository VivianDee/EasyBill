<?php

use App\Helpers\ResponseHelper;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
        //    "SetJsonResponse" => \App\Http\Middleware\SetJsonResponse::class,
            "abilities" =>
            \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
            "ability" =>
            \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
            "VerifyApiKey" => \App\Http\Middleware\VerifyApiKey::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (
            BadRequestHttpException $e,
            Request $request
        ) {
            return ResponseHelper::error("Bad Request");
        });
        $exceptions->render(function (
            AccessDeniedHttpException $e,
            Request $request
        ) {
            return ResponseHelper::unauthorized(
                "Access Denied - Invalid Token"
            );
        });
        $exceptions->render(function (
            NotFoundHttpException $e,
            Request $request
        ) {
            return ResponseHelper::notFound(message: "Invalid Route");
        });

        $exceptions->render(function (
            MethodNotAllowedHttpException $e,
            Request $request
        ) {
            return ResponseHelper::error(
                message: "Method not allowed for api route"
            );
        });

        $exceptions->render(function (
            RouteNotFoundException $e,
            Request $request
        ) {
            return ResponseHelper::unauthorized();
        });
    })->create();
