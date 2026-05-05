@csrf

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Template Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $template->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label for="channel" class="form-label">Channel</label>
                <select class="form-select @error('channel') is-invalid @enderror" id="channel" name="channel" required>
                    @foreach ($channels as $channel)
                        <option value="{{ $channel }}" @selected(old('channel', $template->channel) === $channel)>{{ str($channel)->headline() }}</option>
                    @endforeach
                </select>
                @error('channel') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject', $template->subject) }}" placeholder="Required for email templates">
                @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label for="body" class="form-label">Body</label>
                <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="8" required>{{ old('body', $template->body) }}</textarea>
                @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>
