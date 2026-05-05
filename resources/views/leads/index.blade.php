@extends('layouts.app')

@section('title', 'Leads')

@php
    $statusClasses = [
        'new' => 'text-bg-secondary',
        'contacted' => 'text-bg-info',
        'qualified' => 'text-bg-primary',
        'converted' => 'text-bg-success',
        'lost' => 'text-bg-danger',
    ];
@endphp

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Leads</h1>
            <p class="text-muted mb-0">Monitor the inbound pipeline, ownership, and conversion progress.</p>
        </div>

        <a href="{{ route('leads.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i>Create Lead
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0 py-3">
            <form action="{{ route('leads.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-4 col-xl-3">
                    <select name="status" class="form-select">
                        <option value="">All statuses</option>
                        @foreach ($statuses as $option)
                            <option value="{{ $option }}" @selected($status === $option)>{{ ucfirst($option) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>

                @if ($status)
                    <div class="col-12 col-md-auto">
                        <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
                    </div>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Source</th>
                        <th>Status</th>
                        <th>Owner</th>
                        <th>Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leads as $lead)
                        <tr>
                            <td class="fw-semibold">{{ $lead->name }}</td>
                            <td>{{ $lead->company ?: 'N/A' }}</td>
                            <td>
                                <div>{{ $lead->email ?: 'No email' }}</div>
                                <div class="small text-muted">{{ $lead->phone ?: 'No phone' }}</div>
                            </td>
                            <td>{{ $lead->source ?: 'Unknown' }}</td>
                            <td><span class="badge {{ $statusClasses[$lead->status] ?? 'text-bg-secondary' }}">{{ ucfirst($lead->status) }}</span></td>
                            <td>{{ $lead->assignedUser?->name ?? 'Unassigned' }}</td>
                            <td>{{ $lead->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('leads.edit', $lead) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-pen me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('Delete this lead?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">No leads found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($leads->hasPages())
            <div class="card-footer bg-body border-0">
                {{ $leads->links() }}
            </div>
        @endif
    </div>
@endsection
