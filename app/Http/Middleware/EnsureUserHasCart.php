<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (!$user->cart) {
                Cart::create(['user_id' => Auth::id()]);
            }
            // Eager load cart items to avoid N+1 in shared layouts
            if ($user instanceof \App\Models\User) {
                $user->load(['cart.items']);
            }
        }
        
        return $next($request);
    }
}
