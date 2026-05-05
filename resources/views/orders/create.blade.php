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
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $oldItems = old('items', []);
        $selectedCustomer = old('customer_id', $defaultCustomerId);
    @endphp

    <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
        @csrf

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end mb-4">
                    <div class="col-lg-6">
                        <label for="customer_id" class="form-label fw-semibold">Customer</label>
                        @if ($canChooseCustomer)
                            <select
                                name="customer_id"
                                id="customer_id"
                                class="form-select form-select-lg @error('customer_id') is-invalid @enderror"
                                required
                            >
                                <option value="">Select customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected((string) $selectedCustomer === (string) $customer->id)>
                                        {{ $customer->name }}{{ $customer->email ? ' - '.$customer->email : '' }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="customer_id" value="{{ $defaultCustomerId }}">
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                value="{{ $customers->first()?->name }}{{ $customers->first()?->email ? ' - '.$customers->first()->email : '' }}"
                                readonly
                            >
                        @endif
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="table-responsive border rounded">
                    <table class="table table-bordered align-middle mb-0" id="orderItemsTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 70px;">#</th>
                                <th style="min-width: 280px;">Description</th>
                                <th style="width: 160px;" class="text-end">Quantity</th>
                                <th style="width: 160px;" class="text-end">Unit Price</th>
                                <th style="width: 160px;" class="text-end">Discount</th>
                                <th style="width: 170px;" class="text-end">Line Total</th>
                                <th style="width: 130px;" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-entry-row">
                                <td class="fw-semibold">+</td>
                                <td>
                                    <select id="draftProduct" class="form-select">
                                        <option value="">Select product</option>
                                        @foreach ($products as $product)
                                            <option
                                                value="{{ $product->id }}"
                                                data-price="{{ (float) $product->price }}"
                                                data-name="{{ $product->name }}"
                                                data-sku="{{ $product->sku }}"
                                            >
                                                {{ $product->name }} ({{ $product->sku }}) - Stock: {{ $product->stock }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" min="1" value="1" id="draftQuantity" class="form-control text-end">
                                </td>
                                <td class="text-end fw-semibold" id="draftUnitPrice">0.00</td>
                                <td>
                                    <input type="number" min="0" step="0.01" value="0" id="draftDiscount" class="form-control text-end">
                                </td>
                                <td class="text-end fw-semibold" id="draftLineTotal">0.00</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-success" id="addOrderRow">
                                        Add
                                    </button>
                                </td>
                            </tr>

                            @foreach ($oldItems as $index => $item)
                                @php
                                    $product = $products->firstWhere('id', (int) ($item['product_id'] ?? 0));
                                    $quantity = max(1, (int) ($item['quantity'] ?? 1));
                                    $itemDiscount = max(0, (float) ($item['discount'] ?? 0));
                                    $lineSubtotal = $product ? (float) $product->price * $quantity : 0;
                                    $lineTotal = max(0, $lineSubtotal - $itemDiscount);
                                @endphp
                                @if ($product)
                                    <tr
                                        class="order-item-row"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-sku="{{ $product->sku }}"
                                        data-price="{{ (float) $product->price }}"
                                        data-quantity="{{ $quantity }}"
                                        data-discount="{{ $itemDiscount }}"
                                    >
                                        <td class="item-number">{{ $index + 1 }}</td>
                                        <td>
                                            <span class="fw-semibold">{{ $product->name }}</span>
                                            <span class="text-muted small d-block">{{ $product->sku }}</span>
                                            <input type="hidden" data-name="product_id" value="{{ $product->id }}">
                                        </td>
                                        <td class="text-end">
                                            {{ $quantity }}
                                            <input type="hidden" data-name="quantity" value="{{ $quantity }}">
                                        </td>
                                        <td class="text-end">{{ number_format((float) $product->price, 2) }}</td>
                                        <td class="text-end">
                                            {{ number_format($itemDiscount, 2) }}
                                            <input type="hidden" data-name="discount" value="{{ $itemDiscount }}">
                                        </td>
                                        <td class="text-end fw-semibold">{{ number_format($lineTotal, 2) }}</td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-outline-danger remove-order-row">Remove</button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end mt-4">
                    <div class="col-md-7 col-lg-5 col-xl-4">
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-muted">Sub Total</span>
                            <span class="fw-semibold" id="subtotalDisplay">0.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-muted">Item Discount</span>
                            <span class="fw-semibold" id="itemDiscountDisplay">0.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <label for="discount" class="text-muted mb-0">Discount</label>
                            <input
                                type="number"
                                min="0"
                                step="0.01"
                                name="discount"
                                id="discount"
                                value="{{ old('discount', 0) }}"
                                class="form-control text-end w-50 @error('discount') is-invalid @enderror"
                            >
                        </div>
                        @error('discount')
                            <div class="text-danger small text-end">{{ $message }}</div>
                        @enderror
                        <div class="d-flex justify-content-between align-items-center py-3 border-top">
                            <span class="h5 mb-0">Grand Total</span>
                            <span class="h4 mb-0 text-primary" id="grandTotalDisplay">0.00</span>
                        </div>
                    </div>
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
@endsection
