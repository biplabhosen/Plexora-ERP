@extends('layouts.app')

@section('title', 'Edit Campaign')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1">Edit Campaign</h1>
            <p class="text-muted mb-0">Update scheduling, trigger rules, content, and publishing behavior.</p>
        </div>
        <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-outline-secondary">Back to Details</a>
    </div>

    <div class="d-flex justify-content-between gap-2 mb-4">
        <form action="{{ $deleteAction }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Delete this campaign?')">Delete Campaign</button>
        </form>
    </div>

    <form action="{{ route('campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('campaigns._form')

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Campaign</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function applyTemplate() {
            const select = document.getElementById('templatePicker');
            const option = select.options[select.selectedIndex];

            if (!option.value) {
                return;
            }

            document.getElementById('channel').value = option.dataset.channel;
            document.getElementById('subject').value = option.dataset.subject || '';
            document.getElementById('content').value = option.dataset.body || '';
        }
    </script>
@endpush
