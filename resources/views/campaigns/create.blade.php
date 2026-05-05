@extends('layouts.app')

@section('title', 'Create Campaign')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1">Create Campaign</h1>
            <p class="text-muted mb-0">Build email, SMS, Facebook, or Instagram automations from the unified campaign engine.</p>
        </div>
        <a href="{{ route('campaigns.index') }}" class="btn btn-outline-secondary">Back to Campaigns</a>
    </div>

    <form action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data">
        @include('campaigns._form')

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('campaigns.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Campaign</button>
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
