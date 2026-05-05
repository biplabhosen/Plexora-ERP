@extends('layouts.app')

@section('title', 'Low Stock Alerts')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Low Stock Alerts</h1>
            <p class="text-muted mb-0">Products at or below MOQ thresholds so your team can restock before fulfillment is impacted.</p>
        </div>

        <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-2"></i>Back to Inventory
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0 py-3">
            <h2 class="h5 mb-0">Products Requiring Attention</h2>
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
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="text-muted">#{{ $product->id }}</td>
                            <td class="fw-semibold">{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->supplier?->company_name ?? 'N/A' }}</td>
                            <td class="fw-semibold">{{ $product->stock }}</td>
                            <td>{{ $product->moq }}</td>
                            <td>
                                @if ($product->stock <= 0)
                                    <span class="badge text-bg-danger">Out of Stock</span>
                                @else
                                    <span class="badge text-bg-warning">Low Stock</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('inventory.adjust', $product) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-sliders me-1"></i>Adjust Stock
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">No low stock products found.</td>
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
