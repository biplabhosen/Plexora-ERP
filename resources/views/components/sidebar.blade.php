<div class="sidebar p-3" id="sidebar">
    <h4 class="text-white mb-4">Plexora ERP</h4>
    <ul class="nav flex-column gap-2">
        @if(auth()->check())
            @php
                $user = auth()->user();
                $role = $user->role?->name;
                $supplier = $user->supplier;
                $supplierStatus = $supplier?->status;
            @endphp
            @if($role === 'admin')
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fa fa-box me-2"></i> Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('inventory.index') }}" class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                        <i class="fa fa-warehouse me-2"></i> Inventory
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="fa fa-shopping-cart me-2"></i> Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('rfqs.index') }}" class="nav-link {{ request()->routeIs('rfqs.*') ? 'active' : '' }}">
                        <i class="fa fa-file-signature me-2"></i> RFQ
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
                        <i class="fa fa-truck me-2"></i> Suppliers
                    </a>
                </li>
                <li>
                    <a href="{{ route('automation.index') }}" class="nav-link {{ request()->routeIs('automation.*') ? 'active' : '' }}">
                        <i class="fa fa-bolt me-2"></i> Automation
                    </a>
                </li>
                <li>
                    <span class="nav-link disabled text-white-50">
                        <i class="fa fa-chart-line me-2"></i> Reports
                    </span>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa fa-users me-2"></i> Users
                    </a>
                </li>
                <li>
                    <div class="text-uppercase small fw-semibold text-white-50 px-3 pt-2">CRM</div>
                </li>
                <li>
                    <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <i class="fa fa-address-book me-2"></i> Customers
                    </a>
                </li>
                <li>
                    <a href="{{ route('leads.index') }}" class="nav-link {{ request()->routeIs('leads.*') ? 'active' : '' }}">
                        <i class="fa fa-filter-circle-dollar me-2"></i> Leads
                    </a>
                </li>
                <li>
                    <span class="nav-link disabled text-white-50">
                        <i class="fa fa-gear me-2"></i> Settings
                    </span>
                </li>
            @elseif($role === 'supplier')
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa fa-gauge-high me-2"></i> Supplier Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fa fa-box me-2"></i> My Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="fa fa-inbox me-2"></i> Received Orders
                    </a>
                </li>
                <li>
                    <div class="text-uppercase small fw-semibold text-white-50 px-3 pt-2">RFQ</div>
                </li>
                <li>
                    <a href="{{ route('rfqs.index') }}" class="nav-link {{ request()->routeIs('rfqs.*') ? 'active' : '' }}">
                        <i class="fa fa-file-signature me-2"></i> All RFQs
                    </a>
                </li>
                <li>
                    <div class="text-uppercase small fw-semibold text-white-50 px-3 pt-2">Inventory</div>
                </li>
                <li>
                    <a href="{{ route('inventory.index') }}" class="nav-link {{ request()->routeIs('inventory.index') || request()->routeIs('inventory.adjust') ? 'active' : '' }}">
                        <i class="fa fa-warehouse me-2"></i> Stock Overview
                    </a>
                </li>
                <li>
                    <a href="{{ route('inventory.low-stock') }}" class="nav-link {{ request()->routeIs('inventory.low-stock') ? 'active' : '' }}">
                        <i class="fa fa-triangle-exclamation me-2"></i> Low Stock Alerts
                    </a>
                </li>
                <li>
                    <a href="{{ route('inventory.logs') }}" class="nav-link {{ request()->routeIs('inventory.logs') ? 'active' : '' }}">
                        <i class="fa fa-clock-rotate-left me-2"></i> Movement Logs
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="fa fa-user me-2"></i> Profile
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="fa fa-user me-2"></i> Profile
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="fa fa-shopping-cart me-2"></i> My Orders
                    </a>
                </li>
                <li>
                    <div class="text-uppercase small fw-semibold text-white-50 px-3 pt-2">RFQ</div>
                </li>
                <li>
                    <a href="{{ route('rfqs.index') }}" class="nav-link {{ request()->routeIs('rfqs.index') || request()->routeIs('rfqs.show') ? 'active' : '' }}">
                        <i class="fa fa-file-signature me-2"></i> All RFQs
                    </a>
                </li>
                <li>
                    <a href="{{ route('rfqs.create') }}" class="nav-link {{ request()->routeIs('rfqs.create') ? 'active' : '' }}">
                        <i class="fa fa-file-circle-plus me-2"></i> Create RFQ
                    </a>
                </li>
                <li>
                    <a href="{{ route('become-supplier') }}" class="nav-link {{ request()->routeIs('become-supplier') ? 'active' : '' }}">
                        <i class="fa fa-truck me-2"></i>
                        @if($supplierStatus === 'pending')
                            Supplier Application
                        @elseif($supplierStatus === 'rejected')
                            Reapply as Supplier
                        @else
                            Become a Supplier
                        @endif
                    </a>
                </li>
            @endif
        @endif
    </ul>
</div>
