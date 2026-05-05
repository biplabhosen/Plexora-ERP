@extends('layouts.app')

@section('title', 'Support Tickets')

@php
    $statusClasses = [
        'open' => 'text-bg-warning',
        'pending' => 'text-bg-info',
        'resolved' => 'text-bg-success',
        'closed' => 'text-bg-secondary',
    ];

    $priorityClasses = [
        'low' => 'text-bg-secondary',
        'medium' => 'text-bg-primary',
        'high' => 'text-bg-warning',
        'urgent' => 'text-bg-danger',
    ];
@endphp

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Support Tickets</h1>
            <p class="text-muted mb-0">Track customer issues, supplier escalations, and automated support responses from one desk.</p>
        </div>

        <a href="{{ route('support-tickets.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i>Create Ticket
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0 py-3 d-flex align-items-center justify-content-between">
            <div>
                <h2 class="h5 mb-1">All Tickets</h2>
                <div class="text-muted small">Paginated support queue with role-aware visibility.</div>
            </div>
            <span class="badge text-bg-dark">{{ $tickets->total() }} total</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Customer</th>
                        <th>Created</th>
                        <th class="text-end">View</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td class="text-muted">#{{ $ticket->id }}</td>
                            <td>
                                <div class="fw-semibold">{{ $ticket->subject }}</div>
                                <div class="small text-muted">{{ Str::limit($ticket->message, 70) }}</div>
                            </td>
                            <td>
                                <span class="badge text-bg-light border text-capitalize">{{ $ticket->category }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $priorityClasses[$ticket->priority] ?? 'text-bg-secondary' }} text-capitalize">{{ $ticket->priority }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $statusClasses[$ticket->status] ?? 'text-bg-secondary' }} text-capitalize">{{ $ticket->status }}</span>
                            </td>
                            <td>{{ $ticket->customer?->name ?? 'N/A' }}</td>
                            <td>{{ $ticket->created_at->format('M d, Y h:i A') }}</td>
                            <td class="text-end">
                                <a href="{{ route('support-tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-eye me-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">No support tickets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($tickets->hasPages())
            <div class="card-footer bg-body border-0">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
@endsection
