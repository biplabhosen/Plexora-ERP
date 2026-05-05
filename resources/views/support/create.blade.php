@extends('layouts.app')

@section('title', 'Create Ticket')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Create Support Ticket</h1>
            <p class="text-muted mb-0">Open a new request for order, payment, delivery, supplier, or general support issues.</p>
        </div>

        <a href="{{ route('support-tickets.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-2"></i>Back to Tickets
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('support-tickets.store') }}" method="POST" class="row g-4">
                @csrf

                <div class="col-12 col-lg-6">
                    <label for="order_id" class="form-label">Order</label>
                    <select name="order_id" id="order_id" class="form-select @error('order_id') is-invalid @enderror">
                        <option value="">Select order</option>
                        @foreach ($orders as $order)
                            <option value="{{ $order->id }}" @selected(old('order_id') == $order->id)>
                                {{ $order->order_number }}{{ $order->customer ? ' - '.$order->customer->name : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('order_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-lg-6">
                    <label for="supplier_id" class="form-label">Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
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

                <div class="col-12 col-lg-8">
                    <label for="subject" class="form-label">Subject</label>
                    <input
                        type="text"
                        name="subject"
                        id="subject"
                        value="{{ old('subject') }}"
                        class="form-control @error('subject') is-invalid @enderror"
                        placeholder="Briefly summarize the issue">
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-lg-2">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select @error('category') is-invalid @enderror">
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" @selected(old('category') === $category)>{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-lg-2">
                    <label for="priority" class="form-label">Priority</label>
                    <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror">
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority }}" @selected(old('priority', 'medium') === $priority)>{{ ucfirst($priority) }}</option>
                        @endforeach
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="message" class="form-label">Message</label>
                    <textarea
                        name="message"
                        id="message"
                        rows="7"
                        class="form-control @error('message') is-invalid @enderror"
                        placeholder="Describe the issue in detail">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('support-tickets.index') }}" class="btn btn-light border">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-paper-plane me-2"></i>Submit Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
