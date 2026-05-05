@extends('layouts.app')

@section('title', 'Edit Automation Rule')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Edit Automation Rule</h1>
        <p class="text-muted mb-0">Adjust rule conditions, recipients, and automation actions safely.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('automation.update', $rule) }}" method="POST">
                @method('PUT')
                @include('automation._form')
            </form>
        </div>
    </div>
@endsection
