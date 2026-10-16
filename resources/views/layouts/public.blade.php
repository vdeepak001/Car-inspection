<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'CarPDI' }} — CarPDI</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet">

        @if (file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            @if (file_exists(public_path('build/manifest.json')))
                @vite(['resources/css/app.css', 'resources/js/app.js'])
            @endif
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
            <style type="text/tailwindcss">
                @theme {
                    --font-sans: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
                    --color-lilac: #f4efff;
                    --color-purple: #6d4bd8;
                    --color-grape: #241b3a;
                    --color-mist: #e6def8;
                    --color-muted: #6d6584;
                }
            </style>
        @endif
    </head>
    <body class="min-h-screen bg-lilac font-sans text-grape antialiased">
        <header class="sticky top-0 z-40 border-b border-white/80 bg-white/75 backdrop-blur-md">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-3.5">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-lg font-extrabold tracking-tight">
                    <img src="{{ asset('images/logo_theme.png') }}" alt="Mangal Finance" class="h-9 w-auto object-contain">
                    <span class="border-l border-mist pl-2.5 text-grape font-bold text-base">CarPDI</span>
                </a>

                @unless (request()->routeIs('login', 'register'))
                    <nav class="hidden items-center gap-7 text-sm font-medium text-muted md:flex" aria-label="Primary">
                        <a href="{{ route('home') }}" @class(['text-purple' => request()->routeIs('home'), 'hover:text-purple' => ! request()->routeIs('home')])>Home</a>
                        <a href="{{ route('pdi.verified') }}" @class(['text-purple' => request()->routeIs('pdi.verified'), 'hover:text-purple' => ! request()->routeIs('pdi.verified')])>Verified Cars</a>
                        <a href="{{ route('about') }}" @class(['text-purple' => request()->routeIs('about'), 'hover:text-purple' => ! request()->routeIs('about')])>About Us</a>
                        <a href="{{ route('pdi') }}" @class(['text-purple' => request()->routeIs('pdi'), 'hover:text-purple' => ! request()->routeIs('pdi')])>Car PDI</a>
                        <a href="{{ route('contact') }}" @class(['text-purple' => request()->routeIs('contact'), 'hover:text-purple' => ! request()->routeIs('contact')])>Contact Us</a>
                    </nav>
                @endunless

                <div class="flex items-center gap-3">
                    @unless (request()->routeIs('login', 'register'))
                        @auth('web')
                            <span class="hidden max-w-32 truncate text-sm font-semibold sm:block">{{ auth('web')->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="rounded-full border border-purple px-4 py-2 text-sm font-semibold text-purple">Log out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full border border-purple px-5 py-2 text-sm font-semibold text-purple transition hover:bg-purple hover:text-white">Login</a>
                        @endauth
                    @endunless
                    <a href="{{ auth('web')->check() ? route('pdi') : route('login') }}" class="grid size-10 place-items-center rounded-full border border-mist bg-white text-purple" aria-label="Account">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="8" r="3.2" />
                            <path stroke-linecap="round" d="M5.5 19.2a6.5 6.5 0 0 1 13 0" />
                        </svg>
                    </a>
                    <details class="relative md:hidden">
                        <summary class="grid size-10 cursor-pointer list-none place-items-center rounded-full border border-mist bg-white [&::-webkit-details-marker]:hidden">Menu</summary>
                        <nav class="absolute right-0 mt-2 flex w-44 flex-col gap-1 rounded-2xl border border-mist bg-white p-3 text-sm shadow-lg" aria-label="Mobile">
                            <a class="rounded-lg px-3 py-2 hover:bg-lilac" href="{{ route('home') }}">Home</a>
                            <a class="rounded-lg px-3 py-2 hover:bg-lilac" href="{{ route('pdi.verified') }}">Verified Cars</a>
                            <a class="rounded-lg px-3 py-2 hover:bg-lilac" href="{{ route('about') }}">About Us</a>
                            <a class="rounded-lg px-3 py-2 hover:bg-lilac" href="{{ route('pdi') }}">Car PDI</a>
                            <a class="rounded-lg px-3 py-2 hover:bg-lilac" href="{{ route('contact') }}">Contact Us</a>
                        </nav>
                    </details>
                </div>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        @include('partials.footer')

        @include('partials.status-toast')
        @stack('scripts')
    </body>
</html>
