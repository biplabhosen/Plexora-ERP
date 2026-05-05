@php
    $cards = [
        [
            'title' => 'Total Orders',
            'value' => number_format($metrics['totalOrders']),
            'icon' => 'fa-shopping-cart',
            'helper' => number_format($metrics['todayOrders']) . ' placed today',
            'accent' => 'primary',
        ],
        [
            'title' => 'Today Orders',
            'value' => number_format($metrics['todayOrders']),
            'icon' => 'fa-calendar-day',
            'helper' => 'Live intake from the last 24 hours',
            'accent' => 'info',
        ],
        [
            'title' => 'Monthly Revenue',
            'value' => '$' . number_format((float) $metrics['monthlyRevenue'], 2),
            'icon' => 'fa-sack-dollar',
            'helper' => 'Booked since ' . now()->startOfMonth()->format('M d'),
            'accent' => 'success',
        ],
        [
            'title' => 'Pending Suppliers',
            'value' => number_format($metrics['pendingSuppliers']),
            'icon' => 'fa-truck-ramp-box',
            'helper' => 'Awaiting approval workflow',
            'accent' => 'warning',
        ],
        [
            'title' => 'Open RFQs',
            'value' => number_format($metrics['openRfqs']),
            'icon' => 'fa-file-signature',
            'helper' => 'Buyer sourcing requests in progress',
            'accent' => 'primary',
        ],
        [
            'title' => 'Low Stock',
            'value' => number_format($metrics['lowStockProducts']),
            'icon' => 'fa-box-open',
            'helper' => 'Products at or below MOQ threshold',
            'accent' => 'danger',
        ],
        [
            'title' => 'Automation Runs Today',
            'value' => number_format($metrics['automationRunsToday']),
            'icon' => 'fa-bolt',
            'helper' => 'Workflow events processed today',
            'accent' => 'secondary',
        ],
    ];
@endphp

<div class="row g-4">
    @foreach ($cards as $card)
        <div class="col-12 col-sm-6 col-xxl">
            <div class="card metric-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between gap-3 mb-4">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">{{ $card['title'] }}</div>
                            <div class="h3 fw-bold mb-1">{{ $card['value'] }}</div>
                        </div>

                        <span class="metric-icon text-{{ $card['accent'] }}">
                            <i class="fa {{ $card['icon'] }}"></i>
                        </span>
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
