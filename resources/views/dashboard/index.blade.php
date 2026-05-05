@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-page">
        <div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1">Dashboard</h1>
                <p class="text-muted mb-0">Executive visibility into orders, revenue, sourcing, inventory health, and workflow automation.</p>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-primary">
                    <i class="fa fa-arrow-trend-up me-2"></i>Review Orders
                </a>
                <a href="{{ route('automation.logs') }}" class="btn btn-outline-secondary">
                    <i class="fa fa-list-check me-2"></i>Workflow Logs
                </a>
            </div>
        </div>

        @include('dashboard.partials.kpi-cards', ['metrics' => $metrics])

        <div class="mt-4">
            @include('dashboard.partials.charts', ['metrics' => $metrics])
        </div>

        <div class="row g-4 mt-1">
            <div class="col-12 col-xl-7">
                @include('dashboard.partials.recent-orders', ['recentOrders' => $metrics['recentOrders']])
            </div>
            <div class="col-12 col-xl-5">
                @include('dashboard.partials.recent-rfqs', ['recentRfqs' => $metrics['recentRfqs']])
            </div>
        </div>

        <div class="mt-4">
            @include('dashboard.partials.alerts', ['metrics' => $metrics])
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .dashboard-page .card {
            border: 0;
            border-radius: 1.1rem;
            box-shadow: 0 0.75rem 2rem rgba(15, 23, 42, 0.08);
        }

        .dashboard-page .metric-card {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at top right, rgba(var(--bs-primary-rgb), 0.15), transparent 38%),
                linear-gradient(180deg, rgba(var(--bs-body-bg-rgb), 0.96), rgba(var(--bs-tertiary-bg-rgb), 1));
        }

        .dashboard-page .metric-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(var(--bs-primary-rgb), 0.12);
            color: var(--bs-primary);
            font-size: 1.1rem;
        }

        .dashboard-page .chart-canvas {
            position: relative;
            min-height: 300px;
        }

        .dashboard-page .table > :not(caption) > * > * {
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
        }

        .dashboard-page .list-group-item {
            border-color: var(--bs-border-color-translucent);
        }

        .dashboard-page .signal-dot {
            width: 0.65rem;
            height: 0.65rem;
            border-radius: 50%;
            display: inline-block;
        }
    </style>
@endpush
