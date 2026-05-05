<div class="row g-4">
    <div class="col-12 col-xxl-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h2 class="h5 mb-1">Orders Last 7 Days</h2>
                        <p class="text-muted small mb-0">Daily order throughput across the past week.</p>
                    </div>
                    <span class="badge text-bg-primary">Bar</span>
                </div>

                <div class="chart-canvas">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xxl-5">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h2 class="h5 mb-1">Revenue Last 30 Days</h2>
                        <p class="text-muted small mb-0">Rolling revenue trend from completed order flow.</p>
                    </div>
                    <span class="badge text-bg-success">Line</span>
                </div>

                <div class="chart-canvas">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xxl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h2 class="h5 mb-1">Top Selling Products</h2>
                        <p class="text-muted small mb-0">Top five items by units sold.</p>
                    </div>
                    <span class="badge text-bg-warning">Top 5</span>
                </div>

                <div class="chart-canvas">
                    <canvas id="topProductsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        (() => {
            const chartDefaults = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                        },
                    },
                },
            };

            new Chart(document.getElementById('ordersChart'), {
                type: 'bar',
                data: {
                    labels: @json($metrics['ordersChart']['labels']),
                    datasets: [{
                        label: 'Orders',
                        data: @json($metrics['ordersChart']['series']),
                        borderRadius: 10,
                        backgroundColor: 'rgba(13, 110, 253, 0.75)',
                        hoverBackgroundColor: 'rgba(13, 110, 253, 0.9)',
                    }],
                },
                options: chartDefaults,
            });

            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: @json($metrics['revenueChart']['labels']),
                    datasets: [{
                        label: 'Revenue',
                        data: @json($metrics['revenueChart']['series']),
                        borderColor: 'rgb(25, 135, 84)',
                        backgroundColor: 'rgba(25, 135, 84, 0.15)',
                        fill: true,
                        tension: 0.35,
                    }],
                },
                options: {
                    ...chartDefaults,
                    scales: {
                        ...chartDefaults.scales,
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: (value) => '$' + Number(value).toLocaleString(),
                            },
                        },
                    },
                },
            });

            new Chart(document.getElementById('topProductsChart'), {
                type: 'bar',
                data: {
                    labels: @json($metrics['topProducts']['labels']),
                    datasets: [{
                        label: 'Units Sold',
                        data: @json($metrics['topProducts']['series']),
                        borderRadius: 8,
                        backgroundColor: [
                            'rgba(13, 110, 253, 0.8)',
                            'rgba(25, 135, 84, 0.8)',
                            'rgba(255, 193, 7, 0.8)',
                            'rgba(13, 202, 240, 0.8)',
                            'rgba(108, 117, 125, 0.8)',
                        ],
                    }],
                },
                options: {
                    ...chartDefaults,
                    indexAxis: 'y',
                },
            });
        })();
    </script>
@endpush
