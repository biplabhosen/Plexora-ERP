<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    @section('title', 'Dashboard')

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-body-secondary">Total Products</h6>
                    <h3 class="mb-0">120</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-body-secondary">Total Orders</h6>
                    <h3 class="mb-0">45</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-body-secondary">Customers</h6>
                    <h3 class="mb-0">88</h3>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
