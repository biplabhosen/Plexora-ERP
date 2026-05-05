@extends('layouts.app')

@section('title', 'Workflow Logs')

@php
    $statusClasses = [
        'success' => 'text-bg-success',
        'failed' => 'text-bg-danger',
    ];
@endphp

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Workflow Logs</h1>
            <p class="text-muted mb-0">Review automation execution history, outcomes, and escalation traces.</p>
        </div>

        <a href="{{ route('automation.index') }}" class="btn btn-outline-primary">
            <i class="fa fa-gears me-2"></i>Back to Rules
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Rule</th>
                        <th>Event</th>
                        <th>Status</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                            <td>{{ $log->automationRule?->name ?? 'System' }}</td>
                            <td>{{ str($log->event)->headline() }}</td>
                            <td>
                                <span class="badge {{ $statusClasses[$log->status] ?? 'text-bg-secondary' }}">
                                    {{ ucfirst($log->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="small text-break">{{ $log->message }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">No workflow logs available yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->hasPages())
            <div class="card-footer bg-body border-0">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
@endsection
