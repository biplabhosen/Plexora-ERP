@extends('layouts.app')

@section('title', 'Customers')

@php
    $segmentClasses = [
        'VIP' => 'text-bg-success',
        'Frequent' => 'text-bg-primary',
        'New' => 'text-bg-info',
        'Inactive' => 'text-bg-secondary',
        'Regular' => 'text-bg-light',
    ];
@endphp

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Customers</h1>
            <p class="text-muted mb-0">Search CRM profiles, monitor spend, and review customer engagement segments.</p>
        </div>

        <a href="{{ route('leads.index') }}" class="btn btn-outline-primary">
            <i class="fa fa-filter-circle-dollar me-2"></i>Open Leads
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0 py-3">
            <form action="{{ route('customers.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="input-group">
                        <span class="input-group-text bg-body">
                            <i class="fa fa-search text-muted"></i>
                        </span>
                        <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search by name, email, or phone">
                    </div>
                </div>

                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-outline-primary w-100">Search</button>
                </div>

                @if ($search)
                    <div class="col-12 col-md-auto">
                        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
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
                        <th class="text-end">Orders</th>
                        <th class="text-end">Spend</th>
                        <th>Segment</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $customer->name }}</div>
                                <div class="small text-muted">{{ $customer->phone ?: 'No phone number' }}</div>
                            </td>
                            <td>{{ $customer->email ?: 'No email' }}</td>
                            <td class="text-end">{{ number_format($customer->orders_count) }}</td>
                            <td class="text-end fw-semibold">${{ number_format((float) ($customer->orders_sum_grand_total ?? 0), 2) }}</td>
                            <td>
                                <span class="badge {{ $segmentClasses[$customer->segment] ?? 'text-bg-secondary' }}">
                                    {{ $customer->segment }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-eye me-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($customers->hasPages())
            <div class="card-footer bg-body border-0">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
@endsection
