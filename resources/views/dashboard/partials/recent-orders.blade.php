@php
    $statusClasses = [
        'pending' => 'text-bg-warning',
        'confirmed' => 'text-bg-primary',
        'completed' => 'text-bg-success',
        'cancelled' => 'text-bg-danger',
    ];
@endphp

<div class="card h-100">
    <div class="card-header bg-body border-0 py-3 d-flex align-items-center justify-content-between">
        <div>
            <h2 class="h5 mb-1">Recent Orders</h2>
            <p class="text-muted small mb-0">Latest five customer orders with status visibility.</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order No</th>
                    <th>Customer</th>
                    <th class="text-end">Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentOrders as $order)
                    <tr>
                        <td class="fw-semibold">{{ $order->order_number }}</td>
                        <td>{{ $order->customer?->name ?? 'Guest Customer' }}</td>
                        <td class="text-end fw-semibold">${{ number_format((float) $order->grand_total, 2) }}</td>
                        <td>
                            <span class="badge {{ $statusClasses[$order->status] ?? 'text-bg-secondary' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">No recent orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
