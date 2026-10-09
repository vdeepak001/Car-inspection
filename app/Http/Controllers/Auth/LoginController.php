<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show the website login form.
     */
    public function create(): View
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    /**
     * Authenticate a website member.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->safe()->only(['email', 'password']);

        if (! Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        if ($request->user('web')?->isAdmin()) {
            Auth::guard('web')->logout();

            throw ValidationException::withMessages([
                'email' => 'This login is for website accounts. Admin accounts use the admin sign-in.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'))
            ->with('status', 'Logged in successfully.');
    }

    /**
     * End the website session without affecting an admin session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('status', 'Logged out successfully.');
    }

    /**
     * Google sign-in is shown on the login page and is not connected.
     */
    public function google(): RedirectResponse
    {
        throw ValidationException::withMessages([
            'email' => 'Google sign-in is not connected. Use your email and password.',
        ]);
    }
}
