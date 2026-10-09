@extends('layouts.public')

@section('content')
    <section class="relative overflow-hidden px-5 py-16">
        <div class="pointer-events-none absolute top-0 left-1/2 size-[36rem] -translate-x-1/2 rounded-full bg-purple/10 blur-3xl"></div>
        <div class="relative mx-auto w-full max-w-md rounded-[2rem] bg-white p-8 shadow-xl shadow-purple/10">
            <h1 class="text-center text-3xl font-extrabold">Welcome Back</h1>
            <p class="mt-2 text-center text-sm text-muted">Login to your account</p>

            <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-4">
                @csrf
                <label class="block text-sm font-medium">
                    Email / Mobile Number
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Email / Mobile Number" class="mt-2 w-full rounded-xl border border-mist bg-lilac/50 px-4 py-3 outline-none focus:border-purple">
                </label>
                @error('email')
                    <p class="text-sm text-purple">{{ $message }}</p>
                @enderror
                <label class="block text-sm font-medium">
                    Password
                    <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Password" class="mt-2 w-full rounded-xl border border-mist bg-lilac/50 px-4 py-3 outline-none focus:border-purple">
                </label>
                @error('password')
                    <p class="text-sm text-purple">{{ $message }}</p>
                @enderror
                <button type="submit" class="w-full rounded-full bg-purple py-3 text-sm font-semibold text-white shadow-lg shadow-purple/25">Login</button>
                <div class="flex items-center justify-between text-xs text-muted">
                    <label class="flex items-center gap-2"><input type="checkbox" name="remember" value="1" class="accent-purple"> Remember me</label>
                    <a href="{{ route('contact') }}" class="font-semibold text-purple">Forgot Password?</a>
                </div>
            </form>

            <div class="my-6 flex items-center gap-3 text-xs text-muted">
                <span class="h-px flex-1 bg-mist"></span>
                OR
                <span class="h-px flex-1 bg-mist"></span>
            </div>

            <form method="POST" action="{{ route('login.google') }}">
                @csrf
                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-full border border-mist py-3 text-sm font-semibold">
                    <span class="text-base font-bold text-[#4285F4]">G</span>
                    Continue with Google
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-muted">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-semibold text-purple">Register</a>
            </p>
        </div>
    </section>
@endsection
