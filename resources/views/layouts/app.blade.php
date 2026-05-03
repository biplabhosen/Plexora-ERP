<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Plexora ERP') }} - @yield('title', 'Dashboard')</title>

    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme || systemTheme);
        })();
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: Figtree, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            overflow-x: hidden;
        }

        .app-shell {
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease, transform 0.3s ease;
            background: #111827;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar.collapsed {
            margin-left: -260px;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            border-radius: 6px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .main-content {
            flex: 1;
            min-width: 0;
            min-height: 100vh;
            transition: background-color 0.2s ease;
            background: var(--bs-tertiary-bg);
        }

        .topbar {
            background: var(--bs-body-bg);
            border-bottom: 1px solid var(--bs-border-color);
            min-height: 64px;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .content-header {
            background: var(--bs-body-bg);
            border-bottom: 1px solid var(--bs-border-color);
        }

        .theme-icon-light,
        [data-bs-theme="dark"] .theme-icon-dark {
            display: none;
        }

        [data-bs-theme="dark"] .theme-icon-light {
            display: inline-block;
        }

        .sidebar-backdrop {
            display: none;
        }

        @media (max-width: 991.98px) {
            body.sidebar-open {
                overflow: hidden;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                transform: translateX(-100%);
                z-index: 1040;
                margin-left: 0;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.35);
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                margin-left: 0;
            }

            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                display: block;
                visibility: hidden;
                opacity: 0;
                background: rgba(15, 23, 42, 0.55);
                transition: opacity 0.2s ease, visibility 0.2s ease;
                z-index: 1030;
            }

            body.sidebar-open .sidebar-backdrop {
                visibility: visible;
                opacity: 1;
            }

            .topbar {
                align-items: flex-start;
            }

            main {
                padding: 1rem !important;
            }

            .content-header {
                padding: 1rem !important;
            }
        }

        @media (max-width: 575.98px) {
            .topbar .dropdown-toggle {
                max-width: 150px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
<div class="app-shell d-flex">
    @include('components.sidebar')
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="closeSidebar()"></div>

    <div class="main-content" id="mainContent">
        @include('components.navbar')

        @isset($header)
            <header class="content-header px-4 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h1 class="h4 mb-0">{{ $header }}</h1>
                </div>
            </header>
        @endisset

        <main class="p-4">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const mobileSidebarQuery = window.matchMedia('(max-width: 991.98px)');

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');

        if (mobileSidebarQuery.matches) {
            document.body.classList.toggle('sidebar-open');
            return;
        }

        sidebar.classList.toggle('collapsed');
        document.body.classList.remove('sidebar-open');
    }

    function closeSidebar() {
        document.body.classList.remove('sidebar-open');
    }

    function setTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('theme', theme);
    }

    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
        setTheme(currentTheme === 'dark' ? 'light' : 'dark');
    }

    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            return;
        }

        document.exitFullscreen();
    }

    mobileSidebarQuery.addEventListener('change', function () {
        closeSidebar();
    });
</script>
@stack('scripts')
</body>
</html>
