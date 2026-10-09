<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} — Lotbook</title>

        @include('partials.theme-boot')
        @fonts

        @unless (file_exists(public_path('build/fonts-manifest.json')))
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|instrument-serif:400,400i" rel="stylesheet">
        @endunless

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
            <style type="text/tailwindcss">
                @theme {
                    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                    --font-serif: 'Instrument Serif', ui-serif, Georgia, serif;
                    --color-ink: #0b0b0b;
                    --color-paper: #f4f4f4;
                    --color-mist: #e4e4e4;
                    --color-muted: #5c5c5c;
                    --color-line: #2a2a2a;
                    --color-signal: #e10600;
                }
                @custom-variant dark (&:where(.dark, .dark *));
            </style>
        @endif
    </head>
    <body class="min-h-screen bg-paper text-ink antialiased dark:bg-ink dark:text-paper">
        <header class="sticky top-0 z-40 border-b border-mist bg-paper/90 backdrop-blur-md dark:border-white/10 dark:bg-ink/90">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-5 py-4 sm:px-8">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-[0.18em] uppercase focus-visible:ring-2 focus-visible:ring-signal focus-visible:outline-none">Lotbook</a>

                <div class="flex items-center gap-3">
                    @include('partials.theme-toggle')

                    @auth('web')
                        <span class="max-w-32 truncate text-sm font-semibold sm:max-w-48" title="{{ auth('web')->user()->name }}">{{ auth('web')->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs font-semibold tracking-[0.16em] text-ink/60 uppercase dark:text-white/60">Log out</button>
                        </form>
                    @endauth
                </div>
            </div>
        </header>

        <main class="mx-auto w-full min-w-0 max-w-7xl px-5 py-12 sm:px-8 lg:py-16">
            @yield('content')
        </main>
    </body>
</html>
