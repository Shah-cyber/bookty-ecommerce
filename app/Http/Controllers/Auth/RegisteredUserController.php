<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign customer role by default
        $user->assignRole('customer');

        event(new Registered($user));

        Auth::login($user);

        $redirectUrl = route('home', absolute: false);
        
        // Return JSON response for AJAX requests
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'message' => 'Registration successful',
                'redirect' => $redirectUrl,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames()
                ]
            ]);
        }

        return redirect($redirectUrl);
    }
}
