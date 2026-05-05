@csrf

<div class="row g-4">
    <div class="col-12 col-lg-6">
        <label for="supplier_id" class="form-label">Supplier</label>
        <select id="supplier_id" name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
            <option value="">Select supplier</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>
                    {{ $supplier->company_name }}
                </option>
            @endforeach
        </select>
        @error('supplier_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-lg-6">
        <label for="title" class="form-label">Title</label>
        <input
            type="text"
            id="title"
            name="title"
            class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title') }}"
            required
        >
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-lg-4">
        <label for="quantity" class="form-label">Quantity</label>
        <input
            type="number"
            id="quantity"
            name="quantity"
            min="1"
            class="form-control @error('quantity') is-invalid @enderror"
            value="{{ old('quantity', 1) }}"
            required
        >
        @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea
            id="description"
            name="description"
            rows="5"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Add sourcing notes, specifications, or commercial requirements."
        >{{ old('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-paper-plane me-2"></i>Create RFQ
    </button>
    <a href="{{ route('rfqs.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
