<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $exceptions->render(function (NotFoundHttpException $e, HttpRequest $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                    'message' => 'NOT FOUND',
                    'status' =>404,
                ], 404);
            }
        });
        $exceptions->render(function (ValidationException $e, HttpRequest $request) {
            if ($request->is('api/*')) {
                
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                    'message' => 'Please Try again',
                    'status' =>422,

                ], 422);
            }
        });
        $exceptions->render(function (AuthenticationException $e, HttpRequest $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                    'message' => 'PLEASE LOGIN',
                    'status' =>401,
                ], 401);
            }
        });
        $exceptions->render(function (AccessDeniedHttpException $e, HttpRequest $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->getMessage(),
                    'message' => 'You have no access for this route',
                    'status' =>403,

                ], 403);
            }
        });
    })->create();
