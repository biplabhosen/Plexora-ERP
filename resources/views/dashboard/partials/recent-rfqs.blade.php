@php
    $statusClasses = [
        'open' => 'text-bg-warning',
        'quoted' => 'text-bg-primary',
        'closed' => 'text-bg-secondary',
    ];
@endphp

<div class="card h-100 px-3">
    <div class="card-header bg-body border-0 py-3 d-flex align-items-center justify-content-between">
        <div>
            <h2 class="h5 mb-1">Recent RFQs</h2>
            <p class="text-muted small mb-0">Latest sourcing requests across buyers and suppliers.</p>
        </div>
        <a href="{{ route('rfqs.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="text-center" style="width: 56px;">#</th>
                    <th>Title</th>
                    <th>Buyer</th>
                    <th>Supplier</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentRfqs as $rfq)
                    <tr>
                        <td class="text-center text-muted fw-semibold">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $rfq->title }}</td>
                        <td>{{ $rfq->buyer?->name ?? 'Unknown Buyer' }}</td>
                        <td>{{ $rfq->supplier?->company_name ?? 'Unassigned' }}</td>
                        <td>{{ number_format($rfq->quantity) }}</td>
                        <td>
                            <span class="badge {{ $statusClasses[$rfq->status] ?? 'text-bg-secondary' }}">
                                {{ ucfirst($rfq->status) }}
                            </span>
                        </td>
                        <td>{{ $rfq->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">No recent RFQs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
