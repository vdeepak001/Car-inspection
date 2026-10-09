<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show the website registration form.
     */
    public function create(): View
    {
        return view('auth.register', [
            'title' => 'Register',
        ]);
    }

    /**
     * Create a website account and sign it in.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::query()->create([
            ...$request->safe()->only(['name', 'phone', 'email', 'password']),
            'is_admin' => false,
        ]);

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('status', 'Logged in successfully.');
    }
}
