@extends('layouts.app')

@section('title', 'RFQs')

@php
    $statusClasses = [
        'open' => 'text-bg-primary',
        'quoted' => 'text-bg-success',
        'closed' => 'text-bg-secondary',
    ];
@endphp

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Request for Quotations</h1>
            <p class="text-muted mb-0">Track buyer RFQs, supplier assignments, and procurement status in one place.</p>
        </div>

        @if (! auth()->user()?->hasRole('supplier'))
            <a href="{{ route('rfqs.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-2"></i>Create RFQ
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Buyer</th>
                        <th>Supplier</th>
                        <th>Qty</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">View</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rfqs as $rfq)
                        <tr>
                            <td class="text-muted">#{{ $rfq->id }}</td>
                            <td class="fw-semibold">{{ $rfq->title }}</td>
                            <td>{{ $rfq->buyer?->name ?? 'N/A' }}</td>
                            <td>{{ $rfq->supplier?->company_name ?? 'Unassigned' }}</td>
                            <td>{{ number_format($rfq->quantity) }}</td>
                            <td>
                                <span class="badge {{ $statusClasses[$rfq->status] ?? 'text-bg-secondary' }}">
                                    {{ ucfirst($rfq->status) }}
                                </span>
                            </td>
                            <td>{{ $rfq->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('rfqs.show', $rfq) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-eye me-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">No RFQs found.</td>
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
@endsection
