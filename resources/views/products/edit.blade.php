@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Edit Product</h1>
            <p class="text-muted mb-0">Update supplier, pricing, inventory, MOQ, and catalog status.</p>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                @include('products._form', [
                    'buttonText' => 'Update Product',
                ])
            </form>
        </div>
    </div>
@endsection
