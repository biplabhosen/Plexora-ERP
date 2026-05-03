<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Plexora ERP') }} - @yield('title', 'Authentication')</title>

    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme || systemTheme);
        })();
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            min-height: 100vh;
            font-family: Figtree, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: var(--bs-secondary-bg);
        }

        .auth-wrapper {
            min-height: 100vh;
        }

        .auth-card {
            max-width: 420px;
            width: 100%;
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 0.75rem 2rem rgba(15, 23, 42, 0.08);
        }

        .auth-brand {
            color: var(--bs-body-color);
            text-decoration: none;
            font-weight: 700;
            letter-spacing: 0;
        }

        .form-control {
            min-height: 46px;
            border-radius: 0.75rem;
        }

        .btn {
            border-radius: 0.75rem;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="container auth-wrapper d-flex align-items-center justify-content-center py-5">
        <div class="auth-card card">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <a href="{{ route('login') }}" class="auth-brand fs-4">{{ config('app.name', 'Plexora ERP') }}</a>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
