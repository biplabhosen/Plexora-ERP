@extends('layouts.app')

@section('title', 'Customer Profile')

@php
    $segmentClasses = [
        'VIP' => 'text-bg-success',
        'Frequent' => 'text-bg-primary',
        'New' => 'text-bg-info',
        'Inactive' => 'text-bg-secondary',
        'Regular' => 'text-bg-light',
    ];

    $orderStatusClasses = [
        'pending' => 'text-bg-warning',
        'confirmed' => 'text-bg-primary',
        'completed' => 'text-bg-success',
        'cancelled' => 'text-bg-danger',
    ];

    $rfqStatusClasses = [
        'open' => 'text-bg-warning',
        'quoted' => 'text-bg-primary',
        'closed' => 'text-bg-secondary',
    ];
@endphp

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $customer->name }}</h1>
            <p class="text-muted mb-0">CRM profile, purchase history, RFQs, and collaboration notes.</p>
        </div>

        <div class="d-flex gap-2">
            <span class="badge {{ $segmentClasses[$segment] ?? 'text-bg-secondary' }} px-3 py-2">{{ $segment }}</span>
            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-2"></i>Back
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
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Profile</h2>
                    <div class="mb-3">
                        <div class="text-muted small text-uppercase">Email</div>
                        <div class="fw-semibold">{{ $customer->email ?: 'No email available' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small text-uppercase">Phone</div>
                        <div class="fw-semibold">{{ $customer->phone ?: 'No phone available' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small text-uppercase">Linked User</div>
                        <div class="fw-semibold">{{ $customer->user?->name ?? 'Standalone CRM contact' }}</div>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase">Created</div>
                        <div class="fw-semibold">{{ $customer->created_at?->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="row g-4">
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-muted small text-uppercase mb-2">Total Orders</div>
                            <div class="h3 mb-0">{{ number_format($kpis['total_orders']) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-muted small text-uppercase mb-2">Total Spent</div>
                            <div class="h3 mb-0">${{ number_format($kpis['total_spent'], 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-muted small text-uppercase mb-2">Avg Order Value</div>
                            <div class="h3 mb-0">${{ number_format($kpis['avg_order_value'], 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-muted small text-uppercase mb-2">Last Order</div>
                            <div class="h6 mb-0">{{ $kpis['last_order_date'] ? \Illuminate\Support\Carbon::parse($kpis['last_order_date'])->format('M d, Y') : 'No orders yet' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-body border-0 py-3">
                    <h2 class="h5 mb-1">Order History</h2>
                    <p class="text-muted small mb-0">Latest commercial activity linked to this customer.</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order No</th>
                                <th class="text-end">Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="fw-semibold">{{ $order->order_number }}</td>
                                    <td class="text-end">${{ number_format((float) $order->grand_total, 2) }}</td>
                                    <td><span class="badge {{ $orderStatusClasses[$order->status] ?? 'text-bg-secondary' }}">{{ ucfirst($order->status) }}</span></td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">No orders available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($orders->hasPages())
                    <div class="card-footer bg-body border-0">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-body border-0 py-3">
                    <h2 class="h5 mb-1">RFQ History</h2>
                    <p class="text-muted small mb-0">Procurement conversations initiated by this customer.</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Supplier</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rfqs as $rfq)
                                <tr>
                                    <td class="fw-semibold">{{ $rfq->title }}</td>
                                    <td>{{ $rfq->supplier?->company_name ?? 'Unassigned' }}</td>
                                    <td>{{ number_format($rfq->quantity) }}</td>
                                    <td><span class="badge {{ $rfqStatusClasses[$rfq->status] ?? 'text-bg-secondary' }}">{{ ucfirst($rfq->status) }}</span></td>
                                    <td>{{ $rfq->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">No RFQs available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($rfqs->hasPages())
                    <div class="card-footer bg-body border-0">
                        {{ $rfqs->links() }}
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-body border-0 py-3">
                    <h2 class="h5 mb-0">Add Internal Note</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.notes.store', $customer) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="note" rows="5" class="form-control @error('note') is-invalid @enderror" placeholder="Capture sales context, follow-up notes, or relationship insights">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-note-sticky me-2"></i>Save Note
                        </button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-body border-0 py-3">
                    <h2 class="h5 mb-1">Interaction Notes</h2>
                    <p class="text-muted small mb-0">Shared internal context across sales, support, and ops.</p>
                </div>
                <div class="card-body">
                    @forelse ($notes as $note)
                        <div class="border rounded-3 p-3 mb-3">
                            <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                <div class="fw-semibold">{{ $note->author?->name ?? 'System' }}</div>
                                <div class="small text-muted">{{ $note->created_at->format('M d, Y h:i A') }}</div>
                            </div>
                            <div class="text-muted">{{ $note->note }}</div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">No internal notes yet.</div>
                    @endforelse
                </div>

                @if ($notes->hasPages())
                    <div class="card-footer bg-body border-0">
                        {{ $notes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
