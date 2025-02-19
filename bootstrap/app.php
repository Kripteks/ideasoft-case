<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\Custom\OrderException;
use Illuminate\Validation\ValidationException;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (Throwable $e) {
            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTrace() : null
            ], $statusCode);
        });
    })->create();
