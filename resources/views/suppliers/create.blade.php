@extends('layouts.app')

@section('title', 'Become a Supplier')

@section('content')
    @php
        $status = $supplierApplication?->status;
        $isPending = $status === 'pending';
        $isApproved = $status === 'approved';
        $isRejected = $status === 'rejected';
        $showForm = ! $isPending && ! $isApproved;
    @endphp

    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Apply to Become a Supplier</h1>
            <p class="text-muted mb-0">Submit your company details for admin review and supplier role approval.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($isPending)
        <div class="alert alert-warning border-0 shadow-sm">
            <div class="fw-semibold mb-1">Application pending</div>
            <div>Your supplier application has been submitted and is waiting for admin approval.</div>
        </div>
    @elseif ($isApproved)
        <div class="alert alert-success border-0 shadow-sm">
            <div class="fw-semibold mb-1">Supplier account approved</div>
            <div>Your account has supplier access now. You can manage your products from the supplier sidebar.</div>
        </div>
    @elseif ($isRejected)
        <div class="alert alert-danger border-0 shadow-sm">
            <div class="fw-semibold mb-1">Application rejected</div>
            <div>You can review your details below and resubmit your supplier application.</div>
        </div>
    @endif

    @if ($showForm)
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('become-supplier.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input
                                type="text"
                                name="company_name"
                                id="company_name"
                                class="form-control @error('company_name') is-invalid @enderror"
                                value="{{ old('company_name', $supplierApplication?->company_name) }}"
                                required
                            >
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-6">
                            <label for="contact_person" class="form-label">Contact Person</label>
                            <input
                                type="text"
                                name="contact_person"
                                id="contact_person"
                                class="form-control @error('contact_person') is-invalid @enderror"
                                value="{{ old('contact_person', $supplierApplication?->contact_person) }}"
                                required
                            >
                            @error('contact_person')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input
                                type="text"
                                name="phone"
                                id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $supplierApplication?->phone) }}"
                            >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-6">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $supplierApplication?->email ?? auth()->user()->email) }}"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea
                                name="address"
                                id="address"
                                rows="4"
                                class="form-control @error('address') is-invalid @enderror"
                            >{{ old('address', $supplierApplication?->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-6">
                            <label for="business_type" class="form-label">Business Type</label>
                            <input
                                type="text"
                                name="business_type"
                                id="business_type"
                                class="form-control @error('business_type') is-invalid @enderror"
                                value="{{ old('business_type', $supplierApplication?->business_type) }}"
                            >
                            @error('business_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-6">
                            <label for="trade_license" class="form-label">Trade License</label>
                            <input
                                type="text"
                                name="trade_license"
                                id="trade_license"
                                class="form-control @error('trade_license') is-invalid @enderror"
                                value="{{ old('trade_license', $supplierApplication?->trade_license) }}"
                            >
                            @error('trade_license')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-paper-plane me-2"></i>{{ $isRejected ? 'Resubmit Application' : 'Apply as Supplier' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
