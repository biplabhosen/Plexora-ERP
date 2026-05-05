@extends('layouts.app')

@section('title', 'Buyer Dashboard')

@section('content')
    <div class="dashboard-page">
        <div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1">Buyer Dashboard</h1>
                <p class="text-muted mb-0">Track your purchasing activity, RFQs, support requests, and spend without exposing enterprise-wide admin metrics.</p>
            </div>

            <div class="d-flex flex-wrap gap-2">
                @if (module_enabled('rfq'))
                    <a href="{{ route('rfqs.create') }}" class="btn btn-primary"><i class="fa fa-file-circle-plus me-2"></i>Create RFQ</a>
                @endif
                @if (module_enabled('orders'))
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary"><i class="fa fa-shopping-cart me-2"></i>View Orders</a>
                @endif
                @if (module_enabled('support'))
                    <a href="{{ route('support-tickets.create') }}" class="btn btn-outline-secondary"><i class="fa fa-ticket me-2"></i>Create Ticket</a>
                @endif
                @if (module_enabled('suppliers'))
                    <a href="{{ route('become-supplier') }}" class="btn btn-outline-secondary"><i class="fa fa-truck me-2"></i>Become Supplier</a>
                @endif
            </div>
        </div>

        @php
            $cards = [
                ['title' => 'My Orders', 'value' => $metrics['myOrders'], 'icon' => 'fa-shopping-cart', 'helper' => 'All orders placed through your account', 'accent' => 'primary'],
                ['title' => 'Pending Orders', 'value' => $metrics['pendingOrders'], 'icon' => 'fa-hourglass-half', 'helper' => 'Orders awaiting processing or confirmation', 'accent' => 'warning'],
                ['title' => 'Completed Orders', 'value' => $metrics['completedOrders'], 'icon' => 'fa-circle-check', 'helper' => 'Confirmed orders in your history', 'accent' => 'success'],
                ['title' => 'My RFQs', 'value' => $metrics['myRfqs'], 'icon' => 'fa-file-signature', 'helper' => 'Sourcing requests created by your team', 'accent' => 'info'],
                ['title' => 'Open Tickets', 'value' => $metrics['openTickets'], 'icon' => 'fa-headset', 'helper' => 'Support issues still in progress', 'accent' => 'danger'],
                ['title' => 'Total Spend', 'value' => '$' . number_format($metrics['totalSpend'], 2), 'icon' => 'fa-wallet', 'helper' => 'Lifetime order spend from your buyer account', 'accent' => 'secondary'],
            ];
        @endphp

        <div class="row g-4">
            @foreach ($cards as $card)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card metric-card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between gap-3 mb-4">
                                <div>
                                    <div class="text-muted small text-uppercase fw-semibold mb-2">{{ $card['title'] }}</div>
                                    <div class="h3 fw-bold mb-1">{{ is_numeric($card['value']) ? number_format($card['value']) : $card['value'] }}</div>
                                </div>
                                <span class="metric-icon text-{{ $card['accent'] }}"><i class="fa {{ $card['icon'] }}"></i></span>
                            </div>
                            <div class="small text-muted d-flex align-items-center gap-2">
                                <span class="signal-dot bg-{{ $card['accent'] }}"></span>
                                <span>{{ $card['helper'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-4 mt-1">
            <div class="col-12 col-xl-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h2 class="h5 mb-1">Orders Last 30 Days</h2>
                                <p class="text-muted small mb-0">Daily order volume from your buyer activity.</p>
                            </div>
                            <span class="badge text-bg-primary">30 Days</span>
                        </div>
                        <div class="chart-canvas"><canvas id="buyerOrdersChart"></canvas></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h2 class="h5 mb-1">Monthly Spend</h2>
                                <p class="text-muted small mb-0">Your spend trend over the last six months.</p>
                            </div>
                            <span class="badge text-bg-success">Spend</span>
                        </div>
                        <div class="chart-canvas"><canvas id="buyerSpendChart"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-12 col-xl-5">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h2 class="h5 mb-1">Recent Orders</h2>
                                <p class="text-muted small mb-0">Latest purchase activity from your account.</p>
                            </div>
                            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr><th>Order</th><th>Status</th><th>Total</th><th>Date</th></tr>
                                </thead>
                                <tbody>
                                    @forelse ($metrics['recentOrders'] as $order)
                                        <tr>
                                            <td class="fw-semibold">{{ $order->order_number }}</td>
                                            <td><span class="badge text-bg-secondary">{{ ucfirst($order->status) }}</span></td>
                                            <td>${{ number_format((float) $order->grand_total, 2) }}</td>
                                            <td>{{ $order->created_at?->format('M d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center text-muted py-4">No orders yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h2 class="h5 mb-1">Recent RFQs</h2>
                                <p class="text-muted small mb-0">Your latest sourcing requests.</p>
                            </div>
                            <a href="{{ route('rfqs.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr><th>Title</th><th>Status</th><th>Supplier</th></tr>
                                </thead>
                                <tbody>
                                    @forelse ($metrics['recentRfqs'] as $rfq)
                                        <tr>
                                            <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($rfq->title, 28) }}</td>
                                            <td><span class="badge text-bg-primary">{{ ucfirst($rfq->status) }}</span></td>
                                            <td>{{ $rfq->supplier?->company_name ?? 'Unassigned' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-muted py-4">No RFQs yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h2 class="h5 mb-1">Recent Tickets</h2>
                                <p class="text-muted small mb-0">Support requests opened by your team.</p>
                            </div>
                            <a href="{{ route('support-tickets.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr><th>Subject</th><th>Status</th></tr>
                                </thead>
                                <tbody>
                                    @forelse ($metrics['recentTickets'] as $ticket)
                                        <tr>
                                            <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($ticket->subject, 24) }}</td>
                                            <td><span class="badge text-bg-warning">{{ ucfirst($ticket->status) }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center text-muted py-4">No tickets yet.</td></tr>
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
        .dashboard-page .card { border: 0; border-radius: 1.1rem; box-shadow: 0 0.75rem 2rem rgba(15, 23, 42, 0.08); }
        .dashboard-page .metric-card { position: relative; overflow: hidden; background: radial-gradient(circle at top right, rgba(var(--bs-primary-rgb), 0.15), transparent 38%), linear-gradient(180deg, rgba(var(--bs-body-bg-rgb), 0.96), rgba(var(--bs-tertiary-bg-rgb), 1)); }
        .dashboard-page .metric-icon { width: 3rem; height: 3rem; border-radius: 1rem; display: inline-flex; align-items: center; justify-content: center; background: rgba(var(--bs-primary-rgb), 0.12); color: var(--bs-primary); font-size: 1.1rem; }
        .dashboard-page .chart-canvas { position: relative; min-height: 300px; }
        .dashboard-page .signal-dot { width: 0.65rem; height: 0.65rem; border-radius: 50%; display: inline-block; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        (() => {
            const defaults = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { grid: { display: false } }, y: { beginAtZero: true } },
            };

            new Chart(document.getElementById('buyerOrdersChart'), {
                type: 'bar',
                data: {
                    labels: @json($metrics['ordersChart']['labels']),
                    datasets: [{ data: @json($metrics['ordersChart']['series']), borderRadius: 10, backgroundColor: 'rgba(13, 110, 253, 0.8)' }],
                },
                options: defaults,
            });

            new Chart(document.getElementById('buyerSpendChart'), {
                type: 'line',
                data: {
                    labels: @json($metrics['spendChart']['labels']),
                    datasets: [{ data: @json($metrics['spendChart']['series']), borderColor: 'rgb(25, 135, 84)', backgroundColor: 'rgba(25, 135, 84, 0.15)', tension: 0.35, fill: true }],
                },
                options: {
                    ...defaults,
                    scales: {
                        ...defaults.scales,
                        y: { beginAtZero: true, ticks: { callback: value => '$' + Number(value).toLocaleString() } },
                    },
                },
            });
        })();
    </script>
@endpush
