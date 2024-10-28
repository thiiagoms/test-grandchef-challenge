<?php

use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Messages\System\SystemMessage;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as SymfonyNotFoundException;

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
        $exceptions->renderable(fn (Throwable $e): JsonResponse => match (true) {
            $e instanceof InvalidParameterException => response()
                ->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR),
            $e instanceof NotFoundException => response()
                ->json(['message' => SystemMessage::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND),
            $e instanceof SymfonyNotFoundException => response()
                ->json(['message' => SystemMessage::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND),
            default => response()->json(['error' => SystemMessage::GENERIC_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR)
        });
    })->create();
