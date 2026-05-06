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

    <div class="row g-4 mb-4">
        <div class="col-12 col-xl-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-body border-0 py-3">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <h2 class="h5 mb-1">Support Bot</h2>
                            <div class="text-muted small">Ask a quick question and test the live chatbot API from this page.</div>
                        </div>
                        <span class="badge rounded-pill text-bg-dark">Live API</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form id="supportBotForm" class="d-flex flex-column gap-3">
                        <div>
                            <label for="supportBotMessage" class="form-label">Message</label>
                            <textarea
                                id="supportBotMessage"
                                class="form-control"
                                rows="4"
                                placeholder="Ask something like: Where is my order?"></textarea>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary support-bot-suggestion" data-message="Where is my order?">Order status</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary support-bot-suggestion" data-message="How about my refund?">Refund</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary support-bot-suggestion" data-message="I need help with my delivery.">Delivery</button>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" id="supportBotClear" class="btn btn-light border">Clear</button>
                            <button type="submit" id="supportBotSubmit" class="btn btn-primary">
                                <i class="fa fa-paper-plane me-2"></i>Ask Bot
                            </button>
                        </div>
                    </form>

                    <div id="supportBotError" class="alert alert-danger mt-3 d-none mb-0"></div>

                    <div class="rounded-4 border bg-body-tertiary p-4 mt-3">
                        <div class="text-muted small mb-2">Bot Reply</div>
                        <div id="supportBotReply" class="fw-medium">Support team will contact you soon.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-7">
            <div class="card border-0 shadow-sm h-100">
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
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        (function () {
            const form = document.getElementById('supportBotForm');

            if (! form) {
                return;
            }

            const messageInput = document.getElementById('supportBotMessage');
            const submitButton = document.getElementById('supportBotSubmit');
            const clearButton = document.getElementById('supportBotClear');
            const replyBox = document.getElementById('supportBotReply');
            const errorBox = document.getElementById('supportBotError');
            const defaultReply = 'Support team will contact you soon.';

            const setLoadingState = (isLoading) => {
                submitButton.disabled = isLoading;
                messageInput.disabled = isLoading;
                submitButton.innerHTML = isLoading
                    ? '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Thinking...'
                    : '<i class="fa fa-paper-plane me-2"></i>Ask Bot';
            };

            const setError = (message) => {
                if (! message) {
                    errorBox.classList.add('d-none');
                    errorBox.textContent = '';
                    return;
                }

                errorBox.textContent = message;
                errorBox.classList.remove('d-none');
            };

            document.querySelectorAll('.support-bot-suggestion').forEach((button) => {
                button.addEventListener('click', () => {
                    messageInput.value = button.dataset.message || '';
                    messageInput.focus();
                });
            });

            clearButton.addEventListener('click', () => {
                messageInput.value = '';
                replyBox.textContent = defaultReply;
                setError(null);
            });

            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const message = messageInput.value.trim();

                if (! message) {
                    setError('Please enter a message before asking the bot.');
                    return;
                }

                setError(null);
                setLoadingState(true);

                try {
                    const response = await fetch('{{ route('api.support.chat') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ message }),
                    });

                    const data = await response.json();

                    if (! response.ok) {
                        throw new Error(data.message || 'Unable to fetch a bot reply right now.');
                    }

                    replyBox.textContent = data.reply || defaultReply;
                } catch (error) {
                    replyBox.textContent = defaultReply;
                    setError(error.message || 'Unable to fetch a bot reply right now.');
                } finally {
                    setLoadingState(false);
                }
            });
        })();
    </script>
@endpush
