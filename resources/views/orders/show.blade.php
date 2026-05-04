@extends('layouts.app')

@section('title', 'Order Details')

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
            <h1 class="h3 mb-1">Order {{ $order->order_number }}</h1>
            <p class="text-muted mb-0">Created {{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2">
            <button type="button" class="btn btn-outline-primary" onclick="window.print()">
                <i class="fa fa-print me-2"></i>Print Invoice
            </button>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-2"></i>Back to Orders
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                        <div>
                            <div class="text-muted small mb-1">Order Summary</div>
                            <h2 class="h4 mb-2">{{ $order->order_number }}</h2>
                            <span class="badge {{ $statusClasses[$order->status] ?? 'text-bg-secondary' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <div class="text-md-end">
                            <div class="text-muted small mb-1">Grand Total</div>
                            <div class="h3 mb-0">${{ number_format((float) $order->grand_total, 2) }}</div>
                        </div>
                    </div>

                    @if ($order->notes)
                        <div class="alert alert-light border mt-4 mb-0">
                            <div class="fw-semibold mb-1">Notes</div>
                            {{ $order->notes }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="text-muted small mb-1">Customer Info</div>
                    <h2 class="h5 mb-2">{{ $order->customer?->name ?? 'Guest Customer' }}</h2>
                    <div class="text-muted">{{ $order->customer?->email ?? 'No email available' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0 py-3">
            <h2 class="h5 mb-0">Items</h2>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Qty</th>
                        <th class="text-end">Line Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $item->product?->name ?? 'Deleted Product' }}</div>
                                <div class="small text-muted">{{ $item->product?->sku }}</div>
                            </td>
                            <td class="text-end">${{ number_format((float) $item->price, 2) }}</td>
                            <td class="text-end">{{ $item->quantity }}</td>
                            <td class="text-end fw-semibold">${{ number_format((float) $item->line_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end border-bottom-0">Subtotal</th>
                        <th class="text-end border-bottom-0">${{ number_format((float) $order->subtotal, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end border-bottom-0">Discount</th>
                        <th class="text-end border-bottom-0">${{ number_format((float) $order->discount, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end border-bottom-0">Tax</th>
                        <th class="text-end border-bottom-0">${{ number_format((float) $order->tax, 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end border-bottom-0">Grand Total</th>
                        <th class="text-end border-bottom-0">${{ number_format((float) $order->grand_total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
