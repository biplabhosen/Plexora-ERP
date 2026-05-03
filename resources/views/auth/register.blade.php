<x-guest-layout>
    @section('title', 'Register')

    <div class="mb-4">
        <h2 class="h4 fw-semibold mb-2">Create account</h2>
        <p class="text-body-secondary mb-0">Fill in your details to get started.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="name">Full name</label>
            <input
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Your full name"
            >
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="email">Email address</label>
            <input
                id="email"
                class="form-control @error('email') is-invalid @enderror"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
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
                autocomplete="new-password"
                placeholder="Create password"
            >
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label" for="password_confirmation">Confirm password</label>
            <input
                id="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Confirm password"
            >
            @error('password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mb-4">
            <button class="btn btn-primary" type="submit">Register</button>
        </div>

        <div class="text-center text-body-secondary">
            Already registered?
            <a class="text-decoration-none fw-semibold" href="{{ route('login') }}">Sign in</a>
        </div>
    </form>
</x-guest-layout>
