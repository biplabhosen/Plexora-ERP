@extends('layouts.app')

@section('title', 'Create Automation Rule')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Create Automation Rule</h1>
        <p class="text-muted mb-0">Define when an event happens and what action the platform should take automatically.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('automation.store') }}" method="POST">
                @include('automation._form')
            </form>
        </div>
    </div>
@endsection
