@php
    $workflowStatusClasses = [
        'success' => 'text-bg-success',
        'failed' => 'text-bg-danger',
    ];

    $alerts = [
        [
            'label' => 'Low stock products',
            'value' => $metrics['lowStockProducts'],
            'class' => $metrics['lowStockProducts'] > 0 ? 'warning' : 'success',
            'icon' => 'fa-box-open',
        ],
        [
            'label' => 'Pending suppliers',
            'value' => $metrics['pendingSuppliers'],
            'class' => $metrics['pendingSuppliers'] > 0 ? 'warning' : 'success',
            'icon' => 'fa-truck-ramp-box',
        ],
        [
            'label' => 'Open RFQs',
            'value' => $metrics['openRfqs'],
            'class' => $metrics['openRfqs'] > 0 ? 'primary' : 'success',
            'icon' => 'fa-file-signature',
        ],
    ];

    $allHealthy = collect($alerts)->every(fn (array $alert): bool => $alert['value'] === 0);
@endphp

<div class="row g-4">
    <div class="col-12 col-xl-4">
        <div class="card h-100 px-3">
            <div class="card-header bg-body border-0 py-3">
                <h2 class="h5 mb-1">Alerts</h2>
                <p class="text-muted small mb-0">Operational exceptions that need admin attention.</p>
            </div>

            <div class="card-body">
                @if ($allHealthy)
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        <div class="fw-semibold mb-1">Platform health looks good</div>
                        <div class="small mb-0">There are no low-stock, supplier approval, or open RFQ alerts right now.</div>
                    </div>
                @endif

                <div class="list-group list-group-flush">
                    @foreach ($alerts as $alert)
                        <div class="list-group-item px-0 py-3 bg-transparent">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="metric-icon text-{{ $alert['class'] }}">
                                        <i class="fa {{ $alert['icon'] }}"></i>
                                    </span>
                                    <div>
                                        <div class="fw-semibold">{{ $alert['label'] }}</div>
                                        <div class="small text-muted">
                                            {{ $alert['value'] === 0 ? 'Healthy and within threshold.' : 'Requires monitoring or follow-up.' }}
                                        </div>
                                    </div>
                                </div>

                                <span class="badge text-bg-{{ $alert['class'] }}">{{ number_format($alert['value']) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-8">
        <div class="card h-100 px-3">
            <div class="card-header bg-body border-0 py-3 d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="h5 mb-1">Workflow Activity</h2>
                    <p class="text-muted small mb-0">Latest workflow execution signals across automation rules.</p>
                </div>
                <a href="{{ route('automation.logs') }}" class="btn btn-sm btn-outline-primary">View All Logs</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Event</th>
                            <th>Status</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($metrics['recentLogs'] as $log)
                            <tr>
                                <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                                <td>
                                    <div class="fw-semibold">{{ str($log->event)->headline() }}</div>
                                    <div class="small text-muted">{{ $log->automationRule?->name ?? 'System Workflow' }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $workflowStatusClasses[$log->status] ?? 'text-bg-secondary' }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ $log->message ?: 'No additional message provided.' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">No workflow activity available yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
