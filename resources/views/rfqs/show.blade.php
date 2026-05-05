@extends('layouts.app')

@section('title', 'RFQ Details')

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
            <h1 class="h3 mb-1">{{ $rfq->title }}</h1>
            <p class="text-muted mb-0">RFQ #{{ $rfq->id }} created {{ $rfq->created_at->format('M d, Y h:i A') }}</p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge {{ $statusClasses[$rfq->status] ?? 'text-bg-secondary' }}">{{ ucfirst($rfq->status) }}</span>
            <a href="{{ route('rfqs.index') }}" class="btn btn-outline-secondary">
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

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">RFQ Summary</h2>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="text-muted small text-uppercase">Buyer</div>
                            <div class="fw-semibold">{{ $rfq->buyer?->name ?? 'N/A' }}</div>
                            <div class="text-muted small">{{ $rfq->buyer?->email }}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="text-muted small text-uppercase">Supplier</div>
                            <div class="fw-semibold">{{ $rfq->supplier?->company_name ?? 'Unassigned' }}</div>
                            <div class="text-muted small">{{ $rfq->supplier?->email ?: $rfq->supplier?->user?->email }}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="text-muted small text-uppercase">Quantity</div>
                            <div class="fw-semibold">{{ number_format($rfq->quantity) }}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="text-muted small text-uppercase">Status</div>
                            <div><span class="badge {{ $statusClasses[$rfq->status] ?? 'text-bg-secondary' }}">{{ ucfirst($rfq->status) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Automation Flow</h2>
                    <p class="text-muted mb-0">When this RFQ is created, the `rfq_created` event triggers the automation engine and queues the supplier notification rule automatically.</p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h5 mb-3">Description</h2>
                    <p class="mb-0 text-muted">{{ $rfq->description ?: 'No additional description provided for this RFQ.' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
