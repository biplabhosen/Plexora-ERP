@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Users</h1>
            <p class="text-muted mb-0">Manage registered users, buyer accounts, admin access, and supplier role visibility.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0 py-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="input-group">
                        <span class="input-group-text bg-body">
                            <i class="fa fa-search text-muted"></i>
                        </span>
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            class="form-control"
                            placeholder="Search by name or email"
                        >
                    </div>
                </div>

                <div class="col-12 col-md-4 col-xl-3">
                    <select name="role" class="form-select">
                        <option value="">All roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @selected($selectedRole === $role->name)>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>

                @if ($search || $selectedRole)
                    <div class="col-12 col-md-auto">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
                    </div>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Supplier Status</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="text-muted">#{{ $user->id }}</td>
                            <td class="fw-semibold">
                                {{ $user->name }}
                                @if (auth()->id() === $user->id)
                                    <span class="badge text-bg-primary ms-2">You</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge text-bg-secondary">
                                    {{ ucfirst($user->role?->name ?? 'unassigned') }}
                                </span>
                            </td>
                            <td>
                                @if ($user->supplier)
                                    @php
                                        $supplierBadge = match ($user->supplier->status) {
                                            'approved' => 'text-bg-success',
                                            'rejected' => 'text-bg-danger',
                                            default => 'text-bg-warning',
                                        };
                                    @endphp
                                    <span class="badge {{ $supplierBadge }}">{{ ucfirst($user->supplier->status) }}</span>
                                @else
                                    <span class="text-muted">Not applied</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at?->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-pen me-1"></i>Edit
                                    </a>

                                    @if (auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user account?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="card-footer bg-body border-0">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
