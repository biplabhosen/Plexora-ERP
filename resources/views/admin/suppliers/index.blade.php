@extends('layouts.app')

@section('title', 'Supplier Approvals')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Supplier Applications</h1>
            <p class="text-muted mb-0">Review vendor applications and control when supplier access is granted.</p>
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

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <a href="{{ route('admin.suppliers.index', ['status' => 'pending']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 {{ $status === 'pending' ? 'border-warning border-2' : '' }}">
                    <div class="card-body">
                        <div class="text-muted small mb-1">Pending Approvals</div>
                        <div class="h3 mb-0">{{ $counts['pending'] ?? 0 }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('admin.suppliers.index', ['status' => 'approved']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 {{ $status === 'approved' ? 'border-success border-2' : '' }}">
                    <div class="card-body">
                        <div class="text-muted small mb-1">Approved Suppliers</div>
                        <div class="h3 mb-0">{{ $counts['approved'] ?? 0 }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('admin.suppliers.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 {{ $status === null ? 'border-primary border-2' : '' }}">
                    <div class="card-body">
                        <div class="text-muted small mb-1">All Suppliers</div>
                        <div class="h3 mb-0">{{ ($counts['pending'] ?? 0) + ($counts['approved'] ?? 0) + ($counts['rejected'] ?? 0) }}</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 py-3">
            <div class="fw-semibold">
                @if ($status)
                    {{ ucfirst($status) }} Suppliers
                @else
                    All Supplier Applications
                @endif
            </div>

            @if ($status)
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa fa-list me-2"></i>View All
                </a>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Company</th>
                        <th>Applicant</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Applied</th>
                        <th>Approved By</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr>
                            <td class="text-muted">#{{ $supplier->id }}</td>
                            <td>
                                <div class="fw-semibold">{{ $supplier->company_name }}</div>
                                @if ($supplier->business_type)
                                    <div class="small text-muted">{{ $supplier->business_type }}</div>
                                @endif
                            </td>
                            <td>
                                <div>{{ $supplier->user?->name ?? $supplier->contact_person }}</div>
                                <div class="small text-muted">{{ $supplier->user?->email ?? $supplier->email }}</div>
                            </td>
                            <td>
                                <div>{{ $supplier->contact_person }}</div>
                                <div class="small text-muted">{{ $supplier->phone ?: 'No phone' }}</div>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match ($supplier->status) {
                                        'approved' => 'text-bg-success',
                                        'rejected' => 'text-bg-danger',
                                        default => 'text-bg-warning',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($supplier->status) }}</span>
                            </td>
                            <td>{{ $supplier->created_at?->format('Y-m-d') }}</td>
                            <td>{{ $supplier->approver?->name ?? '-' }}</td>
                            <td class="text-end">
                                @if ($supplier->status === 'pending')
                                    <div class="d-inline-flex gap-2">
                                        <form method="POST" action="{{ route('admin.suppliers.approve', $supplier) }}">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-success"
                                                onclick="return confirm('Approve this supplier application?')"
                                            >
                                                <i class="fa fa-check me-1"></i>Approve
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.suppliers.reject', $supplier) }}">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Reject this supplier application?')"
                                            >
                                                <i class="fa fa-xmark me-1"></i>Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted">No action required</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                No supplier applications found for this view.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
