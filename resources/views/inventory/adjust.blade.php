@extends('layouts.app')

@section('title', 'Adjust Stock')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Adjust Stock</h1>
            <p class="text-muted mb-0">Apply a manual inventory correction with a clear stock movement trail.</p>
        </div>

        <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-2"></i>Back to Inventory
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-body border-0 py-3">
                    <h2 class="h5 mb-0">Adjustment Form</h2>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('inventory.update', $product) }}" method="POST" class="row g-3">
                        @csrf

                        <div class="col-12">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input
                                id="product_name"
                                type="text"
                                class="form-control"
                                value="{{ $product->name }}"
                                readonly
                            >
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="current_stock" class="form-label">Current Stock</label>
                            <input
                                id="current_stock"
                                type="text"
                                class="form-control"
                                value="{{ $product->stock }}"
                                readonly
                            >
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="type" class="form-label">Adjustment Type</label>
                            <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="add" @selected(old('type') === 'add')>Add</option>
                                <option value="remove" @selected(old('type') === 'remove')>Remove</option>
                                <option value="set" @selected(old('type') === 'set')>Set</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input
                                id="quantity"
                                name="quantity"
                                type="number"
                                min="1"
                                class="form-control @error('quantity') is-invalid @enderror"
                                value="{{ old('quantity') }}"
                                required
                            >
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="note" class="form-label">Note</label>
                            <textarea
                                id="note"
                                name="note"
                                rows="4"
                                class="form-control @error('note') is-invalid @enderror"
                                placeholder="Optional reason for this stock adjustment"
                            >{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-floppy-disk me-2"></i>Submit Adjustment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
