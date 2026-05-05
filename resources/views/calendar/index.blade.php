@extends('layouts.app')

@section('title', 'Campaign Calendar')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Content Calendar</h1>
            <p class="text-muted mb-0">Monthly visibility into upcoming marketing automations and scheduled social posts.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('calendar.index', ['month' => $currentMonth->copy()->subMonth()->format('Y-m')]) }}" class="btn btn-outline-secondary">
                <i class="fa fa-chevron-left"></i>
            </a>
            <span class="btn btn-light disabled">{{ $currentMonth->format('F Y') }}</span>
            <a href="{{ route('calendar.index', ['month' => $currentMonth->copy()->addMonth()->format('Y-m')]) }}" class="btn btn-outline-secondary">
                <i class="fa fa-chevron-right"></i>
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered align-top mb-0">
                <thead class="table-light">
                    <tr>
                        @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                            <th class="text-center">{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($weeks as $week)
                        <tr>
                            @foreach ($week as $day)
                                @php
                                    $dateKey = $day->toDateString();
                                    $items = $campaignsByDate->get($dateKey, collect());
                                    $isCurrentMonth = $day->month === $currentMonth->month;
                                @endphp
                                <td class="p-3 {{ $isCurrentMonth ? '' : 'bg-body-tertiary text-muted' }}" style="width: 14.28%; min-height: 150px;">
                                    <div class="fw-semibold mb-2">{{ $day->format('d') }}</div>
                                    <div class="d-grid gap-2">
                                        @foreach ($items as $campaign)
                                            <a href="{{ route('campaigns.show', $campaign) }}" class="text-decoration-none">
                                                <div class="rounded-3 p-2 {{ $campaign->type === 'marketing' ? 'bg-primary-subtle text-primary-emphasis' : 'bg-success-subtle text-success-emphasis' }}">
                                                    <div class="small fw-semibold">{{ $campaign->name }}</div>
                                                    <div class="small">{{ optional($campaign->scheduled_at)->format('h:i A') }}</div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
