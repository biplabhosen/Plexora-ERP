@extends('layouts.app')

@section('title', 'Create RFQ')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Create RFQ</h1>
        <p class="text-muted mb-0">Submit a request for quotation and notify the right supplier automatically.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('rfqs.store') }}" method="POST">
                @include('rfqs._form')
            </form>
        </div>
    </div>
@endsection
