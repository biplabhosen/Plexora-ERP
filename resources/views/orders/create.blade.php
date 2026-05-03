@extends('layouts.app')

@section('title', 'Create Order')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Create Order</h1>
            <p class="text-muted mb-0">Place an order and automatically reserve stock from the selected products.</p>
        </div>

        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-2"></i>Back to Orders
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            Please review the highlighted order details and try again.
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-body border-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 py-3">
                <div>
                    <h2 class="h5 mb-1">Order Items</h2>
                    <p class="text-muted mb-0 small">Choose active products and quantities for this order.</p>
                </div>

                <button type="button" class="btn btn-outline-primary" id="addOrderRow">
                    <i class="fa fa-plus me-2"></i>Add Row
                </button>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="orderItemsTable">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width: 280px;">Product</th>
                                <th style="width: 160px;">Quantity</th>
                                <th style="width: 120px;" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $oldItems = old('items', [['product_id' => '', 'quantity' => 1]]);
                            @endphp

                            @foreach ($oldItems as $index => $item)
                                <tr>
                                    <td>
                                        <select name="items[{{ $index }}][product_id]" class="form-select @error("items.$index.product_id") is-invalid @enderror" required>
                                            <option value="">Select product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" @selected((string) ($item['product_id'] ?? '') === (string) $product->id)>
                                                    {{ $product->name }} ({{ $product->sku }}) - Stock: {{ $product->stock }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error("items.$index.product_id")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input
                                            type="number"
                                            min="1"
                                            name="items[{{ $index }}][quantity]"
                                            value="{{ $item['quantity'] ?? 1 }}"
                                            class="form-control @error("items.$index.quantity") is-invalid @enderror"
                                            required
                                        >
                                        @error("items.$index.quantity")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-outline-danger remove-order-row">
                                            <i class="fa fa-trash me-1"></i>Remove
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <label for="notes" class="form-label">Notes</label>
                <textarea
                    name="notes"
                    id="notes"
                    rows="4"
                    class="form-control @error('notes') is-invalid @enderror"
                    placeholder="Internal order note or customer requirement"
                >{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check me-2"></i>Submit Order
                    </button>
                </div>
            </div>
        </div>
    </form>

    <template id="orderRowTemplate">
        <tr>
            <td>
                <select data-name="product_id" class="form-select" required>
                    <option value="">Select product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }} ({{ $product->sku }}) - Stock: {{ $product->stock }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" min="1" value="1" data-name="quantity" class="form-control" required>
            </td>
            <td class="text-end">
                <button type="button" class="btn btn-outline-danger remove-order-row">
                    <i class="fa fa-trash me-1"></i>Remove
                </button>
            </td>
        </tr>
    </template>
@endsection

@push('scripts')
    <script>
        const orderItemsTable = document.querySelector('#orderItemsTable tbody');
        const orderRowTemplate = document.querySelector('#orderRowTemplate');
        const addOrderRow = document.querySelector('#addOrderRow');

        function renameOrderRows() {
            orderItemsTable.querySelectorAll('tr').forEach((row, index) => {
                row.querySelectorAll('[data-name]').forEach((input) => {
                    input.name = `items[${index}][${input.dataset.name}]`;
                });
            });
        }

        function updateRemoveButtons() {
            const buttons = orderItemsTable.querySelectorAll('.remove-order-row');
            buttons.forEach((button) => {
                button.disabled = buttons.length === 1;
            });
        }

        addOrderRow.addEventListener('click', () => {
            const row = orderRowTemplate.content.cloneNode(true);
            orderItemsTable.appendChild(row);
            renameOrderRows();
            updateRemoveButtons();
        });

        orderItemsTable.addEventListener('click', (event) => {
            const button = event.target.closest('.remove-order-row');

            if (! button || orderItemsTable.querySelectorAll('tr').length === 1) {
                return;
            }

            button.closest('tr').remove();
            renameOrderRows();
            updateRemoveButtons();
        });

        orderItemsTable.querySelectorAll('select, input').forEach((input) => {
            if (! input.dataset.name) {
                input.dataset.name = input.name.includes('[product_id]') ? 'product_id' : 'quantity';
            }
        });

        renameOrderRows();
        updateRemoveButtons();
    </script>
@endpush
