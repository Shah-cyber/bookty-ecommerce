<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse|JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        // Determine redirect URL based on user role
        $user = Auth::user();
        $redirectUrl = '/';
        
        if ($user->hasRole('superadmin')) {
            $redirectUrl = route('superadmin.dashboard', absolute: false);
        } elseif ($user->hasRole('admin')) {
            $redirectUrl = route('admin.dashboard', absolute: false);
        } else {
            // For regular customers, redirect to home page, not dashboard
            $redirectUrl = route('home', absolute: false);
        }
        
        // Return JSON response for AJAX requests
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'message' => 'Login successful',
                'redirect' => $redirectUrl,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames()
                ]
            ]);
        }
        
        return redirect()->intended($redirectUrl);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse|JsonResponse
    {
        $userName = Auth::user() ? Auth::user()->name : null;
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Return JSON response for AJAX requests
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'message' => 'Logout successful',
                'user_name' => $userName,
                'redirect' => '/'
            ]);
        }

        return redirect('/');
    }
}
