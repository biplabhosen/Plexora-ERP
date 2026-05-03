<section>
    <div class="mb-4">
        <h2 class="h5 mb-1">{{ __('Update Password') }}</h2>
        <p class="text-body-secondary mb-0">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label class="form-label" for="update_password_current_password">{{ __('Current Password') }}</label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="form-control {{ $errors->updatePassword->has('current_password') ? 'is-invalid' : '' }}"
                autocomplete="current-password"
            >
            @foreach ($errors->updatePassword->get('current_password') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
        </div>

        <div class="mb-3">
            <label class="form-label" for="update_password_password">{{ __('New Password') }}</label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                class="form-control {{ $errors->updatePassword->has('password') ? 'is-invalid' : '' }}"
                autocomplete="new-password"
            >
            @foreach ($errors->updatePassword->get('password') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
        </div>

        <div class="mb-3">
            <label class="form-label" for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control {{ $errors->updatePassword->has('password_confirmation') ? 'is-invalid' : '' }}"
                autocomplete="new-password"
            >
            @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
        </div>

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <span class="text-success">{{ __('Saved.') }}</span>
            @endif
        </div>
    </form>
</section>
