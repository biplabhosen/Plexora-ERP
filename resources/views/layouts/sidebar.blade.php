@php
    $user = auth()->user();
    $role = $user?->role?->name;
    $supplierStatus = $user?->supplier?->status;
    $normalizedRole = str($role)->lower()->replace([' ', '-'], '_')->toString();
    $dashboardRoute = match ($normalizedRole) {
        'admin', 'marketing_manager', 'support_agent' => route('admin.dashboard'),
        'supplier' => route('supplier.dashboard'),
        default => route('buyer.dashboard'),
    };
    $dashboardActive = request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('buyer.dashboard') || request()->routeIs('supplier.dashboard');
@endphp

<div class="sidebar p-3" id="sidebar">
    <h4 class="text-white mb-4">Plexora ERP</h4>

    @auth
        <ul class="nav flex-column gap-2">
            @if (in_array($normalizedRole, ['admin', 'marketing_manager', 'support_agent'], true))
                <li>
                    <a href="{{ $dashboardRoute }}" class="nav-link {{ $dashboardActive ? 'active' : '' }}">
                        <i class="fa fa-gauge-high me-2"></i> Dashboard
                    </a>
                </li>

                @if ($user->hasRole('admin'))
                    @if (module_enabled('products'))
                        <li><a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"><i class="fa fa-box me-2"></i> Products</a></li>
                    @endif
                    @if (module_enabled('inventory'))
                        <li><a href="{{ route('inventory.index') }}" class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}"><i class="fa fa-warehouse me-2"></i> Inventory</a></li>
                    @endif
                    @if (module_enabled('orders'))
                        <li><a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"><i class="fa fa-shopping-cart me-2"></i> Orders</a></li>
                    @endif
                    @if (module_enabled('suppliers'))
                        <li><a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}"><i class="fa fa-truck me-2"></i> Suppliers</a></li>
                    @endif
                    @if (module_enabled('rfq'))
                        <li><a href="{{ route('rfqs.index') }}" class="nav-link {{ request()->routeIs('rfqs.*') ? 'active' : '' }}"><i class="fa fa-file-signature me-2"></i> RFQ</a></li>
                    @endif
                    @if (module_enabled('workflow'))
                        <li><a href="{{ route('automation.index') }}" class="nav-link {{ request()->routeIs('automation.*') ? 'active' : '' }}"><i class="fa fa-bolt me-2"></i> Automation</a></li>
                    @endif
                    @if (module_enabled('marketing') || module_enabled('social'))
                        <li><a href="{{ route('campaigns.index') }}" class="nav-link {{ request()->routeIs('campaigns.*') ? 'active' : '' }}"><i class="fa fa-bullhorn me-2"></i> Campaigns</a></li>
                    @endif
                    <li><a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fa fa-users me-2"></i> Users</a></li>
                    @if (module_enabled('crm'))
                        <li><a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"><i class="fa fa-address-book me-2"></i> Customers</a></li>
                        <li><a href="{{ route('leads.index') }}" class="nav-link {{ request()->routeIs('leads.*') ? 'active' : '' }}"><i class="fa fa-filter-circle-dollar me-2"></i> Leads</a></li>
                    @endif
                    <li><a href="{{ route('admin.modules.index') }}" class="nav-link {{ request()->routeIs('admin.modules.*') ? 'active' : '' }}"><i class="fa fa-gear me-2"></i> Settings</a></li>
                @elseif ($user->hasRole('marketing_manager'))
                    @if (module_enabled('marketing') || module_enabled('social'))
                        <li><a href="{{ route('campaigns.index') }}" class="nav-link {{ request()->routeIs('campaigns.*') ? 'active' : '' }}"><i class="fa fa-bullhorn me-2"></i> Campaigns</a></li>
                        <li><a href="{{ route('calendar.index') }}" class="nav-link {{ request()->routeIs('calendar.*') ? 'active' : '' }}"><i class="fa fa-calendar-days me-2"></i> Calendar</a></li>
                    @endif
                    @if (module_enabled('crm'))
                        <li><a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"><i class="fa fa-address-book me-2"></i> Customers</a></li>
                    @endif
                @elseif ($user->hasRole('support_agent'))
                    @if (module_enabled('support'))
                        <li><a href="{{ route('support-tickets.index') }}" class="nav-link {{ request()->routeIs('support-tickets.*') ? 'active' : '' }}"><i class="fa fa-headset me-2"></i> Tickets</a></li>
                    @endif
                @endif
            @elseif ($user->hasRole('supplier'))
                <li><a href="{{ $dashboardRoute }}" class="nav-link {{ $dashboardActive ? 'active' : '' }}"><i class="fa fa-gauge-high me-2"></i> Dashboard</a></li>
                @if (module_enabled('products'))
                    <li><a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"><i class="fa fa-box me-2"></i> Products</a></li>
                @endif
                @if (module_enabled('inventory'))
                    <li><a href="{{ route('inventory.index') }}" class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}"><i class="fa fa-warehouse me-2"></i> Inventory</a></li>
                @endif
                @if (module_enabled('orders'))
                    <li><a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"><i class="fa fa-shopping-cart me-2"></i> Orders</a></li>
                @endif
                @if (module_enabled('rfq'))
                    <li><a href="{{ route('rfqs.index') }}" class="nav-link {{ request()->routeIs('rfqs.*') ? 'active' : '' }}"><i class="fa fa-file-signature me-2"></i> RFQs</a></li>
                @endif
                @if (module_enabled('support'))
                    <li><a href="{{ route('support-tickets.index') }}" class="nav-link {{ request()->routeIs('support-tickets.*') ? 'active' : '' }}"><i class="fa fa-headset me-2"></i> Tickets</a></li>
                @endif
                <li><a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"><i class="fa fa-user me-2"></i> Profile</a></li>
            @else
                <li><a href="{{ $dashboardRoute }}" class="nav-link {{ $dashboardActive ? 'active' : '' }}"><i class="fa fa-gauge-high me-2"></i> Dashboard</a></li>
                <li><a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"><i class="fa fa-user me-2"></i> Profile</a></li>
                @if (module_enabled('orders'))
                    <li><a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"><i class="fa fa-shopping-cart me-2"></i> My Orders</a></li>
                @endif
                @if (module_enabled('support'))
                    <li><a href="{{ route('support-tickets.index') }}" class="nav-link {{ request()->routeIs('support-tickets.*') ? 'active' : '' }}"><i class="fa fa-headset me-2"></i> Tickets</a></li>
                @endif
                @if (module_enabled('rfq'))
                    <li><a href="{{ route('rfqs.index') }}" class="nav-link {{ request()->routeIs('rfqs.*') ? 'active' : '' }}"><i class="fa fa-file-signature me-2"></i> All RFQs</a></li>
                    <li><a href="{{ route('rfqs.create') }}" class="nav-link {{ request()->routeIs('rfqs.create') ? 'active' : '' }}"><i class="fa fa-file-circle-plus me-2"></i> Create RFQ</a></li>
                @endif
                @if (module_enabled('suppliers'))
                    <li>
                        <a href="{{ route('become-supplier') }}" class="nav-link {{ request()->routeIs('become-supplier') ? 'active' : '' }}">
                            <i class="fa fa-truck me-2"></i>
                            @if ($supplierStatus === 'pending')
                                Become a Supplier
                            @elseif ($supplierStatus === 'rejected')
                                Reapply as Supplier
                            @else
                                Become a Supplier
                            @endif
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    @endauth
</div>
