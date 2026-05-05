@csrf

<div class="row g-4">
    <div class="col-12 col-lg-6">
        <label for="name" class="form-label">Rule Name</label>
        <input
            type="text"
            id="name"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $rule->name) }}"
            required
        >
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-lg-3">
        <label for="event" class="form-label">Event</label>
        <select id="event" name="event" class="form-select @error('event') is-invalid @enderror" required>
            @foreach ($events as $value => $label)
                <option value="{{ $value }}" @selected(old('event', $rule->event) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('event')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-lg-3">
        <label for="action" class="form-label">Action</label>
        <select id="action" name="action" class="form-select @error('action') is-invalid @enderror" required>
            @foreach ($actions as $value => $label)
                <option value="{{ $value }}" @selected(old('action', $rule->action) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('action')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-lg-6">
        <label for="condition" class="form-label">Condition</label>
        <input
            type="text"
            id="condition"
            name="condition"
            class="form-control @error('condition') is-invalid @enderror"
            value="{{ old('condition', $rule->condition) }}"
            placeholder="Optional, e.g. unresolved_24h or stock <= 5"
        >
        @error('condition')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-lg-6">
        <label for="target" class="form-label">Target</label>
        <input
            type="text"
            id="target"
            name="target"
            class="form-control @error('target') is-invalid @enderror"
            value="{{ old('target', $rule->target) }}"
            placeholder="Optional email override or recipient key"
        >
        @error('target')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="is_active"
                name="is_active"
                value="1"
                @checked(old('is_active', $rule->exists ? $rule->is_active : true))
            >
            <label class="form-check-label" for="is_active">Rule is active</label>
        </div>
    </div>
</div>

<div class="d-flex flex-column flex-sm-row gap-2 mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save me-2"></i>Save Rule
    </button>
    <a href="{{ route('automation.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
