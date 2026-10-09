@extends('layouts.public')

@section('content')
    <section class="relative overflow-hidden px-5 py-16">
        <div class="pointer-events-none absolute top-0 left-1/2 size-[36rem] -translate-x-1/2 rounded-full bg-purple/10 blur-3xl"></div>
        <div class="relative mx-auto w-full max-w-md rounded-[2rem] bg-white p-8 shadow-xl shadow-purple/10">
            <h1 class="text-center text-3xl font-extrabold">Create Account</h1>
            <p class="mt-2 text-center text-sm text-muted">Register to book and track your inspection</p>

            <form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-4">
                @csrf
                <label class="block text-sm font-medium">Name
                    <input name="name" value="{{ old('name') }}" required autocomplete="name" class="mt-2 w-full rounded-xl border border-mist bg-lilac/50 px-4 py-3 outline-none focus:border-purple">
                </label>
                @error('name')<p class="text-sm text-purple">{{ $message }}</p>@enderror
                <label class="block text-sm font-medium">Phone number
                    <input name="phone" value="{{ old('phone') }}" required autocomplete="tel" class="mt-2 w-full rounded-xl border border-mist bg-lilac/50 px-4 py-3 outline-none focus:border-purple">
                </label>
                @error('phone')<p class="text-sm text-purple">{{ $message }}</p>@enderror
                <label class="block text-sm font-medium">Email
                    <input name="email" type="email" value="{{ old('email') }}" required autocomplete="username" class="mt-2 w-full rounded-xl border border-mist bg-lilac/50 px-4 py-3 outline-none focus:border-purple">
                </label>
                @error('email')<p class="text-sm text-purple">{{ $message }}</p>@enderror
                <label class="block text-sm font-medium">Password
                    <input name="password" type="password" required autocomplete="new-password" class="mt-2 w-full rounded-xl border border-mist bg-lilac/50 px-4 py-3 outline-none focus:border-purple">
                </label>
                @error('password')<p class="text-sm text-purple">{{ $message }}</p>@enderror
                <label class="block text-sm font-medium">Confirm password
                    <input name="password_confirmation" type="password" required autocomplete="new-password" class="mt-2 w-full rounded-xl border border-mist bg-lilac/50 px-4 py-3 outline-none focus:border-purple">
                </label>
                <button type="submit" class="w-full rounded-full bg-purple py-3 text-sm font-semibold text-white">Register</button>
            </form>
            <p class="mt-6 text-center text-sm text-muted">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-purple">Login</a>
            </p>
        </div>
    </section>
@endsection
