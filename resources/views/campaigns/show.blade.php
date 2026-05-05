@extends('layouts.app')

@section('title', 'Campaign Details')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $campaign->name }}</h1>
            <p class="text-muted mb-0">Review campaign details, execution logs, and engagement placeholders.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <form action="{{ route('campaigns.run', $campaign) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-play me-2"></i>Run Now
                </button>
            </form>
            <a href="{{ route('campaigns.edit', $campaign) }}" class="btn btn-outline-secondary">Edit Campaign</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="text-muted small text-uppercase">Type</div>
                            <div class="fw-semibold">{{ str($campaign->type)->headline() }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small text-uppercase">Channel</div>
                            <div class="fw-semibold">{{ str($campaign->channel)->headline() }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small text-uppercase">Status</div>
                            <div class="fw-semibold">{{ str($campaign->status)->headline() }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small text-uppercase">Scheduled Time</div>
                            <div class="fw-semibold">{{ optional($campaign->scheduled_at)->format('d M Y, h:i A') ?: 'Not scheduled' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small text-uppercase">Trigger Event</div>
                            <div class="fw-semibold">{{ $campaign->trigger_event ? str($campaign->trigger_event)->headline() : 'Manual / Time-based' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small text-uppercase">Audience</div>
                            <div class="fw-semibold">{{ $campaign->audience ?: 'Not specified' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted small text-uppercase">Subject</div>
                            <div class="fw-semibold">{{ $campaign->subject ?: 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted small text-uppercase">Content</div>
                            <div class="border rounded-3 p-3 bg-body-tertiary">{{ $campaign->content }}</div>
                        </div>
                        @if ($campaign->media_path)
                            <div class="col-12">
                                <div class="text-muted small text-uppercase">Media Path</div>
                                <div class="fw-semibold">{{ $campaign->media_path }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5 mb-3">Campaign Metadata</h2>
                    <div class="d-grid gap-2 small">
                        <div><strong>Created By:</strong> {{ $campaign->creator?->name ?: 'System' }}</div>
                        <div><strong>Active:</strong> {{ $campaign->is_active ? 'Yes' : 'No' }}</div>
                        <div><strong>Created:</strong> {{ $campaign->created_at->format('d M Y, h:i A') }}</div>
                        <div><strong>Updated:</strong> {{ $campaign->updated_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h5 mb-3">Engagement Placeholder</h2>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="rounded-3 bg-body-tertiary p-3 text-center">
                                <div class="text-muted small">Likes</div>
                                <div class="h4 mb-0">{{ $engagementPlaceholder['likes'] }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="rounded-3 bg-body-tertiary p-3 text-center">
                                <div class="text-muted small">Comments</div>
                                <div class="h4 mb-0">{{ $engagementPlaceholder['comments'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0">
            <h2 class="h5 mb-0">Campaign Logs</h2>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Executed At</th>
                        <th>Channel</th>
                        <th>Status</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($campaign->logs as $log)
                        <tr>
                            <td>{{ optional($log->executed_at)->format('d M Y, h:i A') ?: '-' }}</td>
                            <td>{{ str($log->channel)->headline() }}</td>
                            <td>{{ str($log->status)->headline() }}</td>
                            <td>{{ $log->message }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No execution logs yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
