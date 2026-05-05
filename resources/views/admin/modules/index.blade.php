@extends('layouts.app')

@section('title', 'Module Control')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Module Control</h1>
            <p class="text-muted mb-0">Enable or disable enterprise modules from one place while keeping your existing dashboard and navigation intact.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.modules.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="row g-4">
            @foreach ($modules as $module)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between gap-3">
                                <div class="me-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-4 bg-primary-subtle text-primary mb-3" style="width: 3rem; height: 3rem;">
                                        <i class="fa {{ $module['icon'] }}"></i>
                                    </div>
                                    <h2 class="h5 mb-2">{{ $module['label'] }}</h2>
                                    <p class="text-muted mb-0">{{ $module['description'] }}</p>
                                </div>

                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="module_{{ $module['key'] }}" name="modules[{{ $module['key'] }}]" value="1" @checked($module['enabled'])>
                                </div>
                            </div>

                            <div class="mt-3">
                                <span class="badge {{ $module['enabled'] ? 'text-bg-success' : 'text-bg-danger' }}">
                                    {{ $module['enabled'] ? 'ON' : 'OFF' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save me-2"></i>Save Module Settings
            </button>
        </div>
    </form>
@endsection
