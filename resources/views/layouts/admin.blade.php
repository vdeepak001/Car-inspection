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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
        @include('partials.admin-theme-colors')
    </head>
    <body>
        <div class="page">
            <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle sidebar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <h1 class="navbar-brand navbar-brand-autodark">
                        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-reset text-decoration-none">
                            <img src="{{ asset('images/admin-avatar.svg') }}" alt="Admin" width="32" height="32" class="rounded-circle">
                            <span class="fw-semibold">Lotbook Admin</span>
                        </a>
                    </h1>
                    <div class="navbar-nav flex-row d-lg-none align-items-center gap-2">
                        <div class="nav-item">
                            @include('partials.admin-theme-toggle')
                        </div>
                        <div class="nav-item">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Log out</button>
                            </form>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse" id="sidebar-menu">
                        <ul class="navbar-nav pt-lg-3">
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" @class(['nav-link', 'active' => request()->routeIs('admin.dashboard', 'admin.users.*')])>
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-users"></i></span>
                                    <span class="nav-link-title">Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.inspections.index') }}" @class(['nav-link', 'active' => request()->routeIs('admin.inspections.*')])>
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-clipboard-check"></i></span>
                                    <span class="nav-link-title">Inspections</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-world"></i></span>
                                    <span class="nav-link-title">Website</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>

            <header class="navbar d-none d-lg-flex d-print-none">
                <div class="container-xl">
                    <div class="navbar-nav flex-row ms-auto align-items-center gap-3">
                        <div class="nav-item">
                            @include('partials.admin-theme-toggle')
                        </div>
                        <div class="nav-item d-flex align-items-center gap-2">
                            <img src="{{ asset('images/admin-avatar.svg') }}" alt="" width="32" height="32" class="avatar avatar-sm">
                            <span class="fw-medium">{{ auth('admin')->user()->name }}</span>
                        </div>
                        <div class="nav-item">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">Log out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="page-wrapper">
                <div class="page-header d-print-none">
                    <div class="container-xl">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <h2 class="page-title">@yield('heading')</h2>
                            </div>
                            <div class="col-auto ms-auto">
                                @yield('actions')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-xl">
                        @yield('content')
                    </div>
                </div>
                <footer class="footer footer-transparent d-print-none">
                    <div class="container-xl">
                        <div class="text-secondary">Lotbook admin</div>
                    </div>
                </footer>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.6.1/dist/js/tabler.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
        <script>
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 4000,
            };

            @if (session('status'))
                toastr.success({{ \Illuminate\Support\Js::from(session('status')) }});
            @endif

            @if ($errors->has('user'))
                toastr.error({{ \Illuminate\Support\Js::from($errors->first('user')) }});
            @endif
        </script>
    </body>
</html>
