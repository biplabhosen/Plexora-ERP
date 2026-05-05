@extends('layouts.app')

@section('title', 'Automation Rules')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Workflow Automation Rules</h1>
            <p class="text-muted mb-0">Manage rule-based automation for orders, RFQs, and low-stock escalations.</p>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2">
            <a href="{{ route('automation.logs') }}" class="btn btn-outline-secondary">
                <i class="fa fa-list-check me-2"></i>View Logs
            </a>
            <a href="{{ route('automation.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-2"></i>Create Rule
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Event</th>
                        <th>Action</th>
                        <th>Target</th>
                        <th>Active</th>
                        <th class="text-end">Edit</th>
                        <th class="text-end">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rules as $rule)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $rule->name }}</div>
                                @if ($rule->condition)
                                    <div class="small text-muted">Condition: {{ $rule->condition }}</div>
                                @endif
                            </td>
                            <td><span class="badge text-bg-primary">{{ str($rule->event)->headline() }}</span></td>
                            <td><span class="badge text-bg-secondary">{{ str($rule->action)->headline() }}</span></td>
                            <td>{{ $rule->target ?: 'Default recipient' }}</td>
                            <td>
                                <span class="badge {{ $rule->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                                    {{ $rule->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('automation.edit', $rule) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-pen me-1"></i>Edit
                                </a>
                            </td>
                            <td class="text-end">
                                <form action="{{ route('automation.destroy', $rule) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this automation rule?')">
                                        <i class="fa fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">No automation rules configured yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($rules->hasPages())
            <div class="card-footer bg-body border-0">
                {{ $rules->links() }}
            </div>
        @endif
    </div>
@endsection
