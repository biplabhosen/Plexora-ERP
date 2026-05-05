@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Campaign Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $campaign->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" @selected(old('type', $campaign->type) === $type)>{{ str($type)->headline() }}</option>
                            @endforeach
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="channel" class="form-label">Channel</label>
                        <select class="form-select @error('channel') is-invalid @enderror" id="channel" name="channel" required>
                            @foreach ($channels as $channel)
                                <option value="{{ $channel }}" @selected(old('channel', $campaign->channel) === $channel)>{{ str($channel)->headline() }}</option>
                            @endforeach
                        </select>
                        @error('channel') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="audience" class="form-label">Audience</label>
                        <input type="text" class="form-control @error('audience') is-invalid @enderror" id="audience" name="audience" value="{{ old('audience', $campaign->audience) }}" placeholder="all_customers, recent_customers, public, or comma-separated recipients">
                        @error('audience') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject', $campaign->subject) }}" placeholder="Required for email campaigns">
                        @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="8" required>{{ old('content', $campaign->content) }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="media" class="form-label">Media Upload</label>
                        <input type="file" class="form-control @error('media') is-invalid @enderror" id="media" name="media">
                        @error('media') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if ($campaign->media_path)
                            <div class="form-text">Current media: {{ $campaign->media_path }}</div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <label for="scheduled_at" class="form-label">Scheduled At</label>
                        <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at', optional($campaign->scheduled_at)->format('Y-m-d\TH:i')) }}">
                        @error('scheduled_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected(old('status', $campaign->status) === $status)>{{ str($status)->headline() }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="trigger_event" class="form-label">Trigger Event</label>
                        <select class="form-select @error('trigger_event') is-invalid @enderror" id="trigger_event" name="trigger_event">
                            <option value="">Manual or scheduled only</option>
                            @foreach ($triggerEvents as $triggerEvent)
                                <option value="{{ $triggerEvent }}" @selected(old('trigger_event', $campaign->trigger_event) === $triggerEvent)>{{ str($triggerEvent)->headline() }}</option>
                            @endforeach
                        </select>
                        @error('trigger_event') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" @checked(old('is_active', $campaign->is_active ?? true))>
                            <label class="form-check-label" for="is_active">Campaign is active</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h2 class="h5 mb-3">Template Library</h2>
                <select id="templatePicker" class="form-select mb-3">
                    <option value="">Select a template</option>
                    @foreach ($templates as $template)
                        <option
                            value="{{ $template->id }}"
                            data-channel="{{ $template->channel }}"
                            data-subject="{{ $template->subject }}"
                            data-body="{{ $template->body }}"
                        >
                            {{ $template->name }} ({{ str($template->channel)->headline() }})
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-outline-primary w-100" onclick="applyTemplate()">Apply Template</button>
                <p class="text-muted small mt-3 mb-0">Templates help standardize email and SMS content across campaigns.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Supported Triggers</h2>
                <div class="small text-muted d-grid gap-2">
                    <div><strong>customer_registered</strong> for welcome automation</div>
                    <div><strong>order_placed</strong> for order confirmation flows</div>
                    <div><strong>rfq_created</strong> for RFQ follow-up sequences</div>
                    <div><strong>campaign_scheduled</strong> for internal campaign workflow chaining</div>
                </div>
            </div>
        </div>
    </div>
</div>
