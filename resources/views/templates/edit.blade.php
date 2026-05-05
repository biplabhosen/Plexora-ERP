@extends('layouts.app')

@section('title', 'Edit Template')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1">Edit Template</h1>
            <p class="text-muted mb-0">Keep reusable campaign messaging accurate and on-brand.</p>
        </div>
        <a href="{{ route('templates.index') }}" class="btn btn-outline-secondary">Back to Templates</a>
    </div>

    <form action="{{ route('templates.update', $template) }}" method="POST">
        @method('PUT')
        @include('templates._form')

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('templates.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Template</button>
        </div>
    </form>
@endsection
