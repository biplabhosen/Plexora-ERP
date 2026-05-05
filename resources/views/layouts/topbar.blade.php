@php
    $roleLabel = auth()->user()?->role?->label ?? str(auth()->user()?->role?->name ?? 'User')->headline()->toString();
@endphp

<div class="topbar d-flex justify-content-between align-items-center gap-2 p-3">
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="toggleSidebar()" title="Toggle sidebar">
            <i class="fa fa-bars"></i>
        </button>
        <span class="badge text-bg-dark border">{{ $roleLabel }}</span>
    </div>

    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="toggleFullScreen()" title="Fullscreen">
            <i class="fa fa-expand"></i>
        </button>

        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="toggleTheme()" title="Light / Dark mode">
            <i class="fa fa-moon theme-icon-dark"></i>
            <i class="fa fa-sun theme-icon-light"></i>
        </button>

        <div class="dropdown">
            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ auth()->user()->name ?? 'User' }}
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fa fa-user me-2"></i>Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            <i class="fa fa-right-from-bracket me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
