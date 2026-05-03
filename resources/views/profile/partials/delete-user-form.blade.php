<section>
    <div class="mb-4">
        <h2 class="h5 mb-1 text-danger">{{ __('Delete Account') }}</h2>
        <p class="text-body-secondary mb-0">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
    </div>

    <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        {{ __('Delete Account') }}
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{ route('profile.destroy') }}" class="modal-content">
                @csrf
                @method('delete')

                <div class="modal-header">
                    <h2 class="modal-title h5" id="confirmUserDeletionModalLabel">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>

                <div class="modal-body">
                    <p class="text-body-secondary">
                        {{ __('Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <label class="form-label" for="password">{{ __('Password') }}</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="form-control {{ $errors->userDeletion->has('password') ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Password') }}"
                    >
                    @foreach ($errors->userDeletion->get('password') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @endforeach
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-danger">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->userDeletion->isNotEmpty())
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const modal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
                    modal.show();
                });
            </script>
        @endpush
    @endif
</section>
