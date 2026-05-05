@extends('layouts.app')

@section('title', 'Campaigns')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Unified Campaign Engine</h1>
            <p class="text-muted mb-0">Manage marketing automation, scheduled social posts, shared logs, and campaign execution from one place.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('calendar.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-calendar-days me-2"></i>Calendar
            </a>
            <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-2"></i>New Campaign
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small text-uppercase">Total Campaigns</div>
                    <div class="display-6 fw-semibold">{{ $campaigns->total() }}</div>
                    <div class="small text-muted">Across marketing automation and social scheduling.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small text-uppercase">Scheduled</div>
                    <div class="display-6 fw-semibold">{{ $campaigns->getCollection()->where('status', 'scheduled')->count() }}</div>
                    <div class="small text-muted">Campaigns queued by time or trigger.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" id="social-accounts">
                <div class="card-body">
                    <div class="text-muted small text-uppercase">Social Accounts</div>
                    <div class="display-6 fw-semibold">{{ $socialAccounts->count() }}</div>
                    <div class="small text-muted">Linked Facebook and Instagram accounts available for publishing.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('campaigns.index') }}" class="btn {{ $type === null ? 'btn-dark' : 'btn-outline-dark' }}">All</a>
                <a href="{{ route('campaigns.index', ['type' => 'marketing']) }}" class="btn {{ $type === 'marketing' ? 'btn-primary' : 'btn-outline-primary' }}">Marketing</a>
                <a href="{{ route('campaigns.index', ['type' => 'social']) }}" class="btn {{ $type === 'social' ? 'btn-success' : 'btn-outline-success' }}">Social</a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Channel</th>
                        <th>Status</th>
                        <th>Scheduled</th>
                        <th>Trigger</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($campaigns as $campaign)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $campaign->name }}</div>
                                <div class="small text-muted">{{ \Illuminate\Support\Str::limit($campaign->content, 90) }}</div>
                            </td>
                            <td><span class="badge {{ $campaign->type === 'marketing' ? 'text-bg-primary' : 'text-bg-success' }}">{{ str($campaign->type)->headline() }}</span></td>
                            <td>{{ str($campaign->channel)->headline() }}</td>
                            <td>
                                <span class="badge {{
                                    match ($campaign->status) {
                                        'scheduled' => 'text-bg-info',
                                        'processing' => 'text-bg-warning',
                                        'sent' => 'text-bg-success',
                                        'failed' => 'text-bg-danger',
                                        default => 'text-bg-secondary',
                                    }
                                }}">
                                    {{ str($campaign->status)->headline() }}
                                </span>
                            </td>
                            <td>{{ optional($campaign->scheduled_at)->format('d M Y, h:i A') ?: 'Not scheduled' }}</td>
                            <td>{{ $campaign->trigger_event ? str($campaign->trigger_event)->headline() : 'Manual / Time-based' }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                    <a href="{{ route('campaigns.edit', $campaign) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">No campaigns found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($campaigns->hasPages())
            <div class="card-footer bg-body border-0">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0">
            <h2 class="h5 mb-0">Social Accounts Snapshot</h2>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Platform</th>
                        <th>Account Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($socialAccounts as $account)
                        <tr>
                            <td>{{ str($account->platform)->headline() }}</td>
                            <td>{{ $account->account_name }}</td>
                            <td>
                                <span class="badge {{ $account->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                                    {{ $account->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No social accounts configured yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
