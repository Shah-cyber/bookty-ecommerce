<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'ensure.cart' => \App\Http\Middleware\EnsureUserHasCart::class,
        ]);
        
        $middleware->web(append: [
            \App\Http\Middleware\EnsureUserHasCart::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle session expiration (401 Unauthorized)
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Your session has expired. Please log in again.',
                    'redirect' => route('home'),
                    'session_expired' => true
                ], 401);
            }
            
            // For regular requests, redirect to home with open_login flag
            return redirect()->route('home', ['open_login' => 'true'])
                ->with('info', 'Your session has expired. Please log in again.');
        });

        // Handle CSRF token expiration (419 Page Expired)
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Your session has expired. Please refresh the page.',
                    'redirect' => route('home'),
                    'session_expired' => true,
                    'csrf_expired' => true
                ], 419);
            }
            
            // For regular form submissions, redirect to home
            return redirect()->route('home')
                ->with('error', 'Your session has expired. Please try again.');
        });
    })->create();
