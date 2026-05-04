@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Edit User</h1>
            <p class="text-muted mb-0">Update account details and manage role access for this user.</p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-2"></i>Back to Users
        </a>
    </div>

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <label for="name" class="form-label">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $user->name) }}"
                            class="form-control @error('name') is-invalid @enderror"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-lg-6">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $user->email) }}"
                            class="form-control @error('email') is-invalid @enderror"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-lg-6">
                        <label for="role_id" class="form-label">Role</label>
                        <select
                            name="role_id"
                            id="role_id"
                            class="form-select @error('role_id') is-invalid @enderror"
                            required
                        >
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" @selected((string) old('role_id', $user->role_id) === (string) $role->id)>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Supplier role should only be used for users with approved supplier applications.
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Supplier Application</label>
                        <input
                            type="text"
                            class="form-control"
                            value="{{ $user->supplier ? ucfirst($user->supplier->status) : 'Not applied' }}"
                            readonly
                        >
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-2"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
