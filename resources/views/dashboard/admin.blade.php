@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="dashboard-page">
        <div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1">Admin Dashboard</h1>
                <p class="text-muted mb-0">Executive visibility into orders, revenue, sourcing, users, support, and workflow automation.</p>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-primary">
                    <i class="fa fa-arrow-trend-up me-2"></i>Review Orders
                </a>
                @if (module_enabled('workflow'))
                    <a href="{{ route('automation.logs') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-list-check me-2"></i>Workflow Logs
                    </a>
                @endif
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

        <div class="row g-4 mt-1">
            <div class="col-12 col-xl-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h2 class="h5 mb-1">Latest Users</h2>
                                <p class="text-muted small mb-0">Newest accounts entering the platform.</p>
                            </div>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 56px;">#</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($metrics['recentUsers'] as $user)
                                        <tr>
                                            <td class="text-center text-muted fw-semibold">{{ $loop->iteration }}</td>
                                            <td class="fw-semibold">{{ $user->name }}</td>
                                            <td>{{ $user->role?->label ?? str($user->role?->name ?? 'Unassigned')->headline() }}</td>
                                            <td><span class="badge {{ $user->status === 'active' ? 'text-bg-success' : 'text-bg-danger' }}">{{ ucfirst($user->status) }}</span></td>
                                            <td>{{ $user->created_at?->format('M d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center text-muted py-4">No recent users found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h2 class="h5 mb-1">Latest Tickets</h2>
                                <p class="text-muted small mb-0">Newest support activity across buyers and suppliers.</p>
                            </div>
                            <a href="{{ route('support-tickets.index') }}" class="btn btn-sm btn-outline-primary">Open Tickets</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 56px;">#</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Priority</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($metrics['recentTickets'] as $ticket)
                                        <tr>
                                            <td class="text-center text-muted fw-semibold">{{ $loop->iteration }}</td>
                                            <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($ticket->subject, 38) }}</td>
                                            <td><span class="badge {{ $ticket->status === 'open' ? 'text-bg-warning' : ($ticket->status === 'resolved' ? 'text-bg-success' : 'text-bg-secondary') }}">{{ ucfirst($ticket->status) }}</span></td>
                                            <td>{{ ucfirst($ticket->priority) }}</td>
                                            <td>{{ $ticket->created_at?->format('M d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center text-muted py-4">No recent tickets found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
