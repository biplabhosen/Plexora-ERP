@extends('layouts.app')

@section('title', 'Orders')

@php
    $statusClasses = [
        'pending' => 'text-bg-warning',
        'confirmed' => 'text-bg-primary',
        'completed' => 'text-bg-success',
        'cancelled' => 'text-bg-danger',
    ];
@endphp

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Orders</h1>
            <p class="text-muted mb-0">Track B2B order placement, totals, customers, and fulfillment status.</p>
        </div>

        <a href="{{ route('orders.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i>Create Order
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
            <form action="{{ route('orders.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-4 col-xl-3">
                    <select name="status" class="form-select">
                        <option value="">All statuses</option>
                        @foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $option)
                            <option value="{{ $option }}" @selected($status === $option)>
                                {{ ucfirst($option) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        Filter
                    </button>
                </div>

                @if ($status)
                    <div class="col-12 col-md-auto">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100">
                            Clear
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th class="text-end">Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="text-muted">#{{ $order->id }}</td>
                            <td class="fw-semibold">{{ $order->order_number }}</td>
                            <td>{{ $order->customer?->name ?? 'Guest Customer' }}</td>
                            <td class="text-end fw-semibold">${{ number_format((float) $order->grand_total, 2) }}</td>
                            <td>
                                <span class="badge {{ $statusClasses[$order->status] ?? 'text-bg-secondary' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-eye me-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="card-footer bg-body border-0">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
