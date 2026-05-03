<x-app-layout>
    <x-slot name="header">
        {{ __('Profile') }}
    </x-slot>

    @section('title', 'Profile')

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card border-danger shadow-sm">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
