<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // For AJAX/JSON requests, return null (handled by unauthenticated method)
        if ($request->expectsJson() || $request->ajax()) {
            return null;
        }

        // For regular requests, redirect to home page
            return route('home');
        }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        // For AJAX/JSON requests, return JSON response with redirect info
        if ($request->expectsJson() || $request->ajax()) {
            abort(response()->json([
                'message' => 'Your session has expired. Please log in again.',
                'redirect' => route('home'),
                'session_expired' => true
            ], 401));
        }

        // For regular requests, use parent behavior (redirects to home)
        parent::unauthenticated($request, $guards);
    }
}


