@extends('layouts.app')

@section('title', 'Movement Logs')

@php
    $typeClasses = [
        'in' => 'text-bg-success',
        'out' => 'text-bg-danger',
        'adjustment' => 'text-bg-warning',
    ];
@endphp

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Movement Logs</h1>
            <p class="text-muted mb-0">A complete audit trail of stock increases, deductions, and manual adjustments.</p>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2">
            @if ($selectedProduct)
                <a href="{{ route('inventory.logs') }}" class="btn btn-outline-secondary">
                    <i class="fa fa-filter-circle-xmark me-2"></i>Clear Filter
                </a>
            @endif
            <a href="{{ route('inventory.index') }}" class="btn btn-primary">
                <i class="fa fa-warehouse me-2"></i>Stock Overview
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0 py-3">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                <div>
                    <h2 class="h5 mb-1">Stock Movement History</h2>
                    <p class="text-muted mb-0 small">
                        @if ($selectedProduct)
                            Filtered for {{ $selectedProduct->name }} ({{ $selectedProduct->sku }}).
                        @else
                            Latest recorded movements across visible inventory.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Before</th>
                        <th>After</th>
                        <th>User</th>
                        <th>Reference</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movements as $movement)
                        <tr>
                            <td>{{ $movement->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <div class="fw-semibold">{{ $movement->product?->name ?? 'Deleted Product' }}</div>
                                <div class="small text-muted">{{ $movement->product?->sku }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $typeClasses[$movement->type] ?? 'text-bg-secondary' }}">
                                    {{ ucfirst($movement->type) }}
                                </span>
                            </td>
                            <td class="fw-semibold">{{ $movement->quantity }}</td>
                            <td>{{ $movement->before_stock }}</td>
                            <td>{{ $movement->after_stock }}</td>
                            <td>{{ $movement->user?->name ?? 'System' }}</td>
                            <td>{{ $movement->reference ?? 'N/A' }}</td>
                            <td>
                                <span class="text-muted">{{ $movement->note ?? 'N/A' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">No stock movement logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($movements->hasPages())
            <div class="card-footer bg-body border-0">
                {{ $movements->links() }}
            </div>
        @endif
    </div>
@endsection
