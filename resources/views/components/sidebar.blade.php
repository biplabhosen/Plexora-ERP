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
                    <div class="text-uppercase small fw-semibold text-white-50 px-3 pt-2">Suppliers</div>
                </li>
                <li>
                    <a href="{{ route('admin.suppliers.index', ['status' => 'pending']) }}" class="nav-link {{ request()->routeIs('admin.suppliers.*') && request('status') === 'pending' ? 'active' : '' }}">
                        <i class="fa fa-hourglass-half me-2"></i> Pending Approvals
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ request()->routeIs('admin.suppliers.*') && !request('status') ? 'active' : '' }}">
                        <i class="fa fa-truck me-2"></i> All Suppliers
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fa fa-box me-2"></i> Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa fa-users me-2"></i> Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="fa fa-shopping-cart me-2"></i> Orders
                    </a>
                </li>
                <!-- Additional admin links can be added here -->
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
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fa fa-warehouse me-2"></i> Inventory
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
