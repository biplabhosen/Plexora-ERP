@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Roles</h1>
            <p class="text-muted mb-0">Review the RBAC roles currently available across the platform and their assigned user counts.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($roles as $role)
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                            <div>
                                <div class="text-muted small text-uppercase fw-semibold mb-2">Role</div>
                                <h2 class="h5 mb-0">{{ $role->label }}</h2>
                            </div>
                            <span class="badge text-bg-primary">{{ $role->users_count }} Users</span>
                        </div>

                        <p class="text-muted mb-0">Assigned users in this access tier: <strong>{{ number_format($role->users_count) }}</strong>.</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center text-muted py-5">
                        No roles found.
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection
