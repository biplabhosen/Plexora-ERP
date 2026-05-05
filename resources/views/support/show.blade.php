@extends('layouts.app')

@section('title', 'Support Ticket')

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
            <h1 class="h3 mb-1">Ticket #{{ $ticket->id }}</h1>
            <p class="text-muted mb-0">{{ $ticket->subject }}</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('support-tickets.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3">
                        <div>
                            <div class="text-muted small mb-1">Ticket Header</div>
                            <h2 class="h4 mb-0">{{ $ticket->subject }}</h2>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge {{ $statusClasses[$ticket->status] ?? 'text-bg-secondary' }} text-capitalize">{{ $ticket->status }}</span>
                            <span class="badge {{ $priorityClasses[$ticket->priority] ?? 'text-bg-secondary' }} text-capitalize">{{ $ticket->priority }}</span>
                            <span class="badge text-bg-light border text-capitalize">{{ $ticket->category }}</span>
                        </div>
                    </div>

                    <div class="small text-muted mb-3">
                        Created {{ $ticket->created_at->format('M d, Y h:i A') }}
                        @if ($ticket->order)
                            <span class="mx-2">|</span>
                            Order {{ $ticket->order->order_number }}
                        @endif
                    </div>

                    <div class="rounded-4 border bg-body-tertiary p-4">
                        <div class="fw-semibold mb-2">Original Message</div>
                        <p class="mb-0">{{ $ticket->message }}</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-body border-0 py-3">
                    <h2 class="h5 mb-0">Replies Thread</h2>
                </div>
                <div class="card-body p-4">
                    @forelse ($ticket->replies as $reply)
                        <div class="border rounded-4 p-3 mb-3 {{ $reply->is_system ? 'bg-warning-subtle border-warning-subtle' : 'bg-body' }}">
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-2">
                                <div class="fw-semibold">
                                    {{ $reply->is_system ? 'System Auto Reply' : ($reply->author?->name ?? 'Unknown User') }}
                                </div>
                                <div class="small text-muted">{{ $reply->created_at->format('M d, Y h:i A') }}</div>
                            </div>
                            <p class="mb-0">{{ $reply->message }}</p>
                        </div>
                    @empty
                        <div class="text-muted">No replies yet.</div>
                    @endforelse
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-body border-0 py-3">
                    <h2 class="h5 mb-0">Reply Form</h2>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('support.reply', $ticket) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea
                                name="message"
                                id="message"
                                rows="5"
                                class="form-control @error('message') is-invalid @enderror"
                                placeholder="Write your reply">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-reply me-2"></i>Send Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="text-muted small mb-1">Customer</div>
                    <div class="fw-semibold">{{ $ticket->customer?->name ?? 'N/A' }}</div>
                    <div class="text-muted">{{ $ticket->customer?->email ?? 'No email available' }}</div>

                    <hr>

                    <div class="text-muted small mb-1">Supplier</div>
                    <div class="fw-semibold">{{ $ticket->supplier?->company_name ?? 'N/A' }}</div>
                    <div class="text-muted">{{ $ticket->supplier?->email ?? 'No supplier email available' }}</div>

                    <hr>

                    <div class="text-muted small mb-1">Assigned To</div>
                    <div class="fw-semibold">{{ $ticket->assignee?->name ?? 'Unassigned' }}</div>
                </div>
            </div>

            @if ($canChangeStatus)
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-body border-0 py-3">
                        <h2 class="h5 mb-0">Change Status</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('support.status', $ticket) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    @foreach (['open', 'pending', 'resolved', 'closed'] as $status)
                                        <option value="{{ $status }}" @selected($ticket->status === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
