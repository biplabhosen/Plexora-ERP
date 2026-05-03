@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Products</h1>
            <p class="text-muted mb-0">Manage marketplace catalog, supplier stock, MOQ, and sales visibility.</p>
        </div>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i>Add Product
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
            <form action="{{ route('products.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-8 col-xl-5">
                    <div class="input-group">
                        <span class="input-group-text bg-body">
                            <i class="fa fa-search text-muted"></i>
                        </span>
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            class="form-control"
                            placeholder="Search by product name or SKU"
                        >
                    </div>
                </div>

                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        Search
                    </button>
                </div>

                @if ($search)
                    <div class="col-12 col-md-auto">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
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
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Supplier</th>
                        <th class="text-end">Price</th>
                        <th>Stock</th>
                        <th>MOQ</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="text-muted">#{{ $product->id }}</td>
                            <td>
                                <span class="fw-semibold">{{ $product->sku }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $product->name }}</div>
                                @if ($product->description)
                                    <div class="small text-muted text-truncate" style="max-width: 260px;">
                                        {{ $product->description }}
                                    </div>
                                @endif
                            </td>
                            <td>{{ $product->supplier?->company_name ?? 'N/A' }}</td>
                            <td class="text-end fw-semibold">${{ number_format((float) $product->price, 2) }}</td>
                            <td>
                                <span class="fw-semibold">{{ $product->stock }}</span>
                                @if ($product->is_low_stock)
                                    <span class="badge text-bg-warning ms-2">Low Stock</span>
                                @endif
                            </td>
                            <td>{{ $product->moq }}</td>
                            <td>
                                @if ($product->status)
                                    <span class="badge text-bg-success">Active</span>
                                @else
                                    <span class="badge text-bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-pen me-1"></i>Edit
                                    </a>

                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-5">
                                No products found.
                            </td>
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
