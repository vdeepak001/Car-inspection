<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <title>{{ $title }} — Lotbook Admin</title>
        @include('partials.admin-theme-boot')
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.6.1/dist/css/tabler.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.48.0/dist/tabler-icons.min.css">
        @include('partials.admin-theme-colors')
    </head>
    <body class="d-flex flex-column">
        <div class="page page-center">
            <div class="container container-tight py-4">
                <div class="d-flex justify-content-end">
                    @include('partials.admin-theme-toggle')
                </div>
                <div class="text-center mb-4">
                    <a href="{{ route('admin.login') }}" class="navbar-brand navbar-brand-autodark d-inline-flex align-items-center gap-2 text-reset text-decoration-none">
                        <img src="{{ asset('images/admin-avatar.svg') }}" alt="Admin" width="36" height="36" class="rounded-circle">
                        <span class="h2 mb-0">Lotbook Admin</span>
                    </a>
                </div>
                <div class="card card-md">
                    <div class="card-body">
                        <h1 class="h2 text-center mb-2">Admin panel</h1>
                        <p class="text-secondary text-center mb-4">This door is only for the admin account. Website members use the Login button on the site.</p>

                        <form method="POST" action="{{ route('admin.login.store') }}" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="admin@lotbook.test" autocomplete="username" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" autocomplete="current-password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary w-100">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center text-secondary mt-3">
                    <a href="{{ route('home') }}">Back to the website</a>
                </div>
            </div>
        </div>

        @include('partials.status-toast')
    </body>
</html>
