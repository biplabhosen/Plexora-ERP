<div class="row g-3">
    <div class="col-12 col-lg-6">
        <label for="supplier_id" class="form-label">Supplier</label>
        @if ($suppliers->count() === 1)
            <input
                type="hidden"
                name="supplier_id"
                value="{{ old('supplier_id', $product->supplier_id ?? $suppliers->first()->id) }}"
            >
            <input
                type="text"
                class="form-control"
                value="{{ $suppliers->first()->company_name }}"
                readonly
            >
        @else
            <select
                name="supplier_id"
                id="supplier_id"
                class="form-select @error('supplier_id') is-invalid @enderror"
                required
            >
                <option value="">Select supplier</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" @selected(old('supplier_id', $product->supplier_id) == $supplier->id)>
                        {{ $supplier->company_name }}
                    </option>
                @endforeach
            </select>
        @endif
        @error('supplier_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-lg-6">
        <label for="sku" class="form-label">SKU</label>
        <input
            type="text"
            name="sku"
            id="sku"
            value="{{ old('sku', $product->sku) }}"
            class="form-control @error('sku') is-invalid @enderror"
            required
        >
        @error('sku')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="name" class="form-label">Name</label>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $product->name) }}"
            class="form-control @error('name') is-invalid @enderror"
            required
        >
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea
            name="description"
            id="description"
            rows="4"
            class="form-control @error('description') is-invalid @enderror"
        >{{ old('description', $product->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <label for="price" class="form-label">Price</label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input
                type="number"
                step="0.01"
                min="0"
                name="price"
                id="price"
                value="{{ old('price', $product->price) }}"
                class="form-control @error('price') is-invalid @enderror"
                required
            >
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <label for="stock" class="form-label">Stock</label>
        <input
            type="number"
            min="0"
            name="stock"
            id="stock"
            value="{{ old('stock', $product->stock) }}"
            class="form-control @error('stock') is-invalid @enderror"
            required
        >
        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <label for="moq" class="form-label">MOQ</label>
        <input
            type="number"
            min="1"
            name="moq"
            id="moq"
            value="{{ old('moq', $product->moq) }}"
            class="form-control @error('moq') is-invalid @enderror"
            required
        >
        @error('moq')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6 col-xl-3">
        <label for="status" class="form-label">Status</label>
        <select
            name="status"
            id="status"
            class="form-select @error('status') is-invalid @enderror"
            required
        >
            <option value="1" @selected(old('status', (int) $product->status) == 1)>Active</option>
            <option value="0" @selected(old('status', (int) $product->status) == 0)>Inactive</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-3 border-top">
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save me-2"></i>{{ $buttonText }}
    </button>
</div>
