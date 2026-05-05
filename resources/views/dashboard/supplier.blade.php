@extends('layouts.app')

@section('title', 'Supplier Dashboard')

@section('content')
    <div class="dashboard-page">
        <div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1">Supplier Dashboard</h1>
                <p class="text-muted mb-0">Stay focused on your catalog, assigned RFQs, stock health, and supplier-side order performance.</p>
            </div>

            <div class="d-flex flex-wrap gap-2">
                @if (module_enabled('products'))
                    <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Add Product</a>
                @endif
                @if (module_enabled('inventory'))
                    <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary"><i class="fa fa-warehouse me-2"></i>Manage Inventory</a>
                @endif
                @if (module_enabled('orders'))
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary"><i class="fa fa-shopping-cart me-2"></i>View Orders</a>
                @endif
            </div>
        </div>

        @if ($metrics['supplierStatus'] !== 'approved')
            <div class="alert alert-warning border-0 shadow-sm">
                Supplier access is not fully approved yet. Dashboard metrics are limited until your supplier account is approved.
            </div>
        @endif

        @php
            $cards = [
                ['title' => 'My Products', 'value' => $metrics['myProducts'], 'icon' => 'fa-box', 'helper' => 'Products currently tied to your supplier account', 'accent' => 'primary'],
                ['title' => 'Pending Orders', 'value' => $metrics['pendingOrders'], 'icon' => 'fa-hourglass-half', 'helper' => 'Orders waiting on supplier-side progress', 'accent' => 'warning'],
                ['title' => 'Confirmed Orders', 'value' => $metrics['confirmedOrders'], 'icon' => 'fa-circle-check', 'helper' => 'Orders already confirmed and moving forward', 'accent' => 'success'],
                ['title' => 'Revenue', 'value' => '$' . number_format($metrics['revenue'], 2), 'icon' => 'fa-sack-dollar', 'helper' => 'Revenue attributable to your sold product lines', 'accent' => 'info'],
                ['title' => 'Open RFQs', 'value' => $metrics['openRfqs'], 'icon' => 'fa-file-signature', 'helper' => 'Active RFQs assigned to your supplier profile', 'accent' => 'secondary'],
                ['title' => 'Low Stock Items', 'value' => $metrics['lowStockItems'], 'icon' => 'fa-triangle-exclamation', 'helper' => 'Products already at or below MOQ threshold', 'accent' => 'danger'],
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
            <div class="col-12 col-xl-7">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h2 class="h5 mb-1">Sales Last 30 Days</h2>
                                <p class="text-muted small mb-0">Revenue generated from your visible order lines.</p>
                            </div>
                            <span class="badge text-bg-success">Sales</span>
                        </div>
                        <div class="chart-canvas"><canvas id="supplierSalesChart"></canvas></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h2 class="h5 mb-1">Product Performance</h2>
                                <p class="text-muted small mb-0">Top products ranked by units sold.</p>
                            </div>
                            <span class="badge text-bg-primary">Top 5</span>
                        </div>
                        <div class="chart-canvas"><canvas id="supplierProductsChart"></canvas></div>
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
                                <p class="text-muted small mb-0">Latest orders that include your product lines.</p>
                            </div>
                            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr><th>Order</th><th>Status</th><th>Date</th></tr>
                                </thead>
                                <tbody>
                                    @forelse ($metrics['recentOrders'] as $order)
                                        <tr>
                                            <td class="fw-semibold">{{ $order->order_number }}</td>
                                            <td><span class="badge text-bg-secondary">{{ ucfirst($order->status) }}</span></td>
                                            <td>{{ $order->created_at?->format('M d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-muted py-4">No orders found.</td></tr>
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
                                <h2 class="h5 mb-1">Assigned RFQs</h2>
                                <p class="text-muted small mb-0">Buyer requests currently routed to your company.</p>
                            </div>
                            <a href="{{ route('rfqs.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr><th>Title</th><th>Status</th><th>Buyer</th></tr>
                                </thead>
                                <tbody>
                                    @forelse ($metrics['assignedRfqs'] as $rfq)
                                        <tr>
                                            <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($rfq->title, 28) }}</td>
                                            <td><span class="badge text-bg-primary">{{ ucfirst($rfq->status) }}</span></td>
                                            <td>{{ $rfq->buyer?->name ?? 'Unknown' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-muted py-4">No RFQs assigned.</td></tr>
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
                                <h2 class="h5 mb-1">Low Stock Products</h2>
                                <p class="text-muted small mb-0">Items needing replenishment attention.</p>
                            </div>
                            <a href="{{ route('inventory.low-stock') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr><th>Product</th><th>Stock</th></tr>
                                </thead>
                                <tbody>
                                    @forelse ($metrics['lowStockProducts'] as $product)
                                        <tr>
                                            <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($product->name, 24) }}</td>
                                            <td><span class="badge text-bg-danger">{{ $product->stock }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center text-muted py-4">No low stock products.</td></tr>
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

            new Chart(document.getElementById('supplierSalesChart'), {
                type: 'line',
                data: {
                    labels: @json($metrics['salesChart']['labels']),
                    datasets: [{ data: @json($metrics['salesChart']['series']), borderColor: 'rgb(25, 135, 84)', backgroundColor: 'rgba(25, 135, 84, 0.15)', fill: true, tension: 0.35 }],
                },
                options: {
                    ...defaults,
                    scales: {
                        ...defaults.scales,
                        y: { beginAtZero: true, ticks: { callback: value => '$' + Number(value).toLocaleString() } },
                    },
                },
            });

            new Chart(document.getElementById('supplierProductsChart'), {
                type: 'bar',
                data: {
                    labels: @json($metrics['productPerformance']['labels']),
                    datasets: [{ data: @json($metrics['productPerformance']['series']), borderRadius: 8, backgroundColor: 'rgba(13, 110, 253, 0.8)' }],
                },
                options: { ...defaults, indexAxis: 'y' },
            });
        })();
    </script>
@endpush
