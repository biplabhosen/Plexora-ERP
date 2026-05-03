<x-guest-layout>
    @section('title', 'Login')

    <div class="mb-4">
        <h2 class="h4 fw-semibold mb-2">Sign in</h2>
        <p class="text-body-secondary mb-0">Enter your email and password to continue.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="email">Email address</label>
            <input
                id="email"
                class="form-control @error('email') is-invalid @enderror"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="name@company.com"
            >
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
            >
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
            <div class="form-check">
                <input id="remember_me" class="form-check-input" type="checkbox" name="remember">
                <label class="form-check-label" for="remember_me">Remember me</label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-decoration-none" href="{{ route('password.request') }}">Forgot your password?</a>
            @endif
        </div>

        <div class="d-grid mb-4">
            <button class="btn btn-primary" type="submit">Log in</button>
        </div>

        <div class="text-center text-body-secondary">
            New to the platform?
            <a class="text-decoration-none fw-semibold" href="{{ route('register') }}">Create an account</a>
        </div>
    </form>
</x-guest-layout>
