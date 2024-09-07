<?php

use App\Helpers\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // customize errors response
        $exceptions->render(function (AuthenticationException $e) {
            return JsonResponse::error('Unauthenticated', [], 401);
        });

        $exceptions->render(function (ValidationException $e) {
            return JsonResponse::error('Validation failed', $e->errors(), 422);
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            return JsonResponse::error('Not Found', $e->getMessage(), 404);
        });

        $exceptions->render(function (InternalErrorException $e) {
            return JsonResponse::error('Something went wrong', $e->getMessage(), 500);
        });

        $exceptions->render(function (ThrottleRequestsException $e) {
            return JsonResponse::error('Too Many Requests', $e->getMessage(), 429);
        });
    })->create();
