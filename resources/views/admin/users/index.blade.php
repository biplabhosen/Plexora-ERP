@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">User Management</h1>
            <p class="text-muted mb-0">Control platform access, assign roles, and manage account activity without leaving the admin panel.</p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fa fa-user-plus me-2"></i>Create User
        </a>
    </div>

    @foreach (['success', 'error'] as $messageType)
        @if (session($messageType))
            <div class="alert alert-{{ $messageType === 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                {{ session($messageType) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endforeach

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0 py-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-12 col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text bg-body">
                            <i class="fa fa-search text-muted"></i>
                        </span>
                        <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search by name or email">
                    </div>
                </div>

                <div class="col-12 col-lg-3">
                    <select name="role_id" class="form-select">
                        <option value="">All roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected((string) $selectedRoleId === (string) $role->id)>{{ $role->label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-lg-auto">
                    <button type="submit" class="btn btn-outline-primary w-100">Apply Filters</button>
                </div>

                @if ($search || $selectedRoleId)
                    <div class="col-12 col-lg-auto">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
                    </div>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="fw-semibold">
                                {{ $user->name }}
                                @if (auth()->id() === $user->id)
                                    <span class="badge text-bg-primary ms-2">You</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge text-bg-secondary">{{ str($user->role?->name ?? 'unassigned')->headline() }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $user->status === 'active' ? 'text-bg-success' : 'text-bg-danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at?->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex flex-wrap justify-content-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-pen me-1"></i>Edit
                                    </a>

                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $user->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                            <i class="fa {{ $user->status === 'active' ? 'fa-ban' : 'fa-check' }} me-1"></i>
                                            {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">No users found.</td>
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
