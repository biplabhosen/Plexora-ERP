@extends('layouts.app')

@section('title', 'Templates')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Message Templates</h1>
            <p class="text-muted mb-0">Reusable email and SMS content blocks for campaign creation.</p>
        </div>
        <a href="{{ route('templates.create') }}" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i>New Template
        </a>
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
                        <th>Channel</th>
                        <th>Subject</th>
                        <th>Body</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($templates as $template)
                        <tr>
                            <td class="fw-semibold">{{ $template->name }}</td>
                            <td>{{ str($template->channel)->headline() }}</td>
                            <td>{{ $template->subject ?: 'N/A' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($template->body, 100) }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('templates.edit', $template) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('templates.destroy', $template) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this template?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">No templates available yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($templates->hasPages())
            <div class="card-footer bg-body border-0">
                {{ $templates->links() }}
            </div>
        @endif
    </div>
@endsection
