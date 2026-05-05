@extends('layouts.app')

@section('title', 'Inventory Overview')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Inventory Overview</h1>
            <p class="text-muted mb-0">Track stock health, supplier inventory coverage, and quick actions across the catalog.</p>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2">
            <a href="{{ route('inventory.low-stock') }}" class="btn btn-outline-warning">
                <i class="fa fa-triangle-exclamation me-2"></i>Low Stock Alerts
            </a>
            <a href="{{ route('inventory.logs') }}" class="btn btn-primary">
                <i class="fa fa-clock-rotate-left me-2"></i>Movement Logs
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
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small text-uppercase mb-2">Total Products</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="display-6 fw-semibold mb-0">{{ $totalProducts }}</div>
                        <span class="badge text-bg-primary">Catalog</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small text-uppercase mb-2">Low Stock Count</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="display-6 fw-semibold mb-0">{{ $lowStockCount }}</div>
                        <span class="badge text-bg-warning">Attention</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small text-uppercase mb-2">Out of Stock Count</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="display-6 fw-semibold mb-0">{{ $outOfStockCount }}</div>
                        <span class="badge text-bg-danger">Critical</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0 py-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="h5 mb-1">Inventory Listing</h2>
                    <p class="text-muted mb-0 small">Review current stock position and jump into adjustments or movement history.</p>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>SKU</th>
                        <th>Product Name</th>
                        <th>Supplier</th>
                        <th>Stock</th>
                        <th>MOQ</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        @php
                            $statusLabel = $product->stock <= 0
                                ? ['Out of Stock', 'text-bg-danger']
                                : ($product->is_low_stock
                                    ? ['Low Stock', 'text-bg-warning']
                                    : ['Healthy', 'text-bg-success']);
                        @endphp
                        <tr>
                            <td class="text-muted">#{{ $product->id }}</td>
                            <td class="fw-semibold">{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->supplier?->company_name ?? 'N/A' }}</td>
                            <td class="fw-semibold">{{ $product->stock }}</td>
                            <td>{{ $product->moq }}</td>
                            <td>
                                <span class="badge {{ $statusLabel[1] }}">
                                    {{ $statusLabel[0] }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex flex-wrap justify-content-end gap-2">
                                    <a href="{{ route('inventory.adjust', $product) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-sliders me-1"></i>Adjust Stock
                                    </a>
                                    <a href="{{ route('inventory.logs', ['product' => $product->id]) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fa fa-eye me-1"></i>View Logs
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">No inventory records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="card-footer bg-body border-0">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
