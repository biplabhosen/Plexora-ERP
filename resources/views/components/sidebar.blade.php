<div class="sidebar p-3" id="sidebar">
    <h4 class="text-white mb-4">Plexora ERP</h4>
    <ul class="nav flex-column gap-2">
        @auth
            @php
                $user = auth()->user();
                $role = $user->role?->name;
                $supplier = $user->supplier;
                $supplierStatus = $supplier?->status;
                $isAdmin = $user->hasRole('admin');
                $isSupplier = $user->hasRole('supplier');
                $isMarketingManager = $user->hasRole('marketing_manager');
                $isSupportAgent = $user->hasRole('support_agent');
            @endphp

            <li>
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa fa-gauge-high me-2"></i> Dashboard
                </a>
            </li>

            @if ($isAdmin)
                @if (module_enabled('products'))
                    <li>
                        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <i class="fa fa-box me-2"></i> Products
                        </a>
                    </li>
                @endif
                @if (module_enabled('inventory'))
                    <li>
                        <a href="{{ route('inventory.index') }}" class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                            <i class="fa fa-warehouse me-2"></i> Inventory
                        </a>
                    </li>
                @endif
                @if (module_enabled('orders'))
                    <li>
                        <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                            <i class="fa fa-shopping-cart me-2"></i> Orders
                        </a>
                    </li>
                @endif
                @if (module_enabled('support'))
                    <li>
                        <div class="text-uppercase small fw-semibold text-white-50 px-3 pt-2">Support</div>
                    </li>
                    <li>
                        <a href="{{ route('support-tickets.index') }}" class="nav-link {{ request()->routeIs('support-tickets.*') ? 'active' : '' }}">
                            <i class="fa fa-headset me-2"></i> Tickets
                        </a>
                    </li>
                @endif
                @if (module_enabled('rfq'))
                    <li>
                        <a href="{{ route('rfqs.index') }}" class="nav-link {{ request()->routeIs('rfqs.*') ? 'active' : '' }}">
                            <i class="fa fa-file-signature me-2"></i> RFQ
                        </a>
                    </li>
                @endif
                @if (module_enabled('suppliers'))
                    <li>
                        <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
                            <i class="fa fa-truck me-2"></i> Suppliers
                        </a>
                    </li>
                @endif
                @if (module_enabled('workflow'))
                    <li>
                        <a href="{{ route('automation.index') }}" class="nav-link {{ request()->routeIs('automation.*') ? 'active' : '' }}">
                            <i class="fa fa-bolt me-2"></i> Automation
                        </a>
                    </li>
                @endif
                @if (module_enabled('marketing') || module_enabled('social'))
                    <li>
                        <div class="text-uppercase small fw-semibold text-white-50 px-3 pt-2">Growth</div>
                    </li>
                @endif
                @if (module_enabled('marketing'))
                    <li>
                        <a href="{{ route('campaigns.index', ['type' => 'marketing']) }}" class="nav-link {{ request()->routeIs('campaigns.*') && request('type') !== 'social' ? 'active' : '' }}">
                            <i class="fa fa-bullhorn me-2"></i> Campaigns
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('templates.index') }}" class="nav-link {{ request()->routeIs('templates.*') ? 'active' : '' }}">
                            <i class="fa fa-envelope-open-text me-2"></i> Templates
                        </a>
                    </li>
                @endif
                @if (module_enabled('social'))
                    <li>
                        <a href="{{ route('campaigns.index', ['type' => 'social']) }}" class="nav-link {{ request()->routeIs('campaigns.*') && request('type') === 'social' ? 'active' : '' }}">
                            <i class="fa fa-share-nodes me-2"></i> Scheduled Posts
                        </a>
                    </li>
                @endif
                @if (module_enabled('marketing') || module_enabled('social'))
                    <li>
                        <a href="{{ route('calendar.index') }}" class="nav-link {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                            <i class="fa fa-calendar-days me-2"></i> Calendar
                        </a>
                    </li>
                @endif
                @if (module_enabled('crm'))
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
                @endif

                <li>
                    <div class="text-uppercase small fw-semibold text-white-50 px-3 pt-2">Administration</div>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa fa-users me-2"></i> Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <i class="fa fa-user-shield me-2"></i> Roles
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.modules.index') }}" class="nav-link {{ request()->routeIs('admin.modules.*') ? 'active' : '' }}">
                        <i class="fa fa-sliders me-2"></i> Module Control
                    </a>
                </li>
            @elseif ($isMarketingManager)
                @if (module_enabled('marketing'))
                    <li>
                        <a href="{{ route('campaigns.index', ['type' => 'marketing']) }}" class="nav-link {{ request()->routeIs('campaigns.*') && request('type') !== 'social' ? 'active' : '' }}">
                            <i class="fa fa-bullhorn me-2"></i> Campaigns
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('templates.index') }}" class="nav-link {{ request()->routeIs('templates.*') ? 'active' : '' }}">
                            <i class="fa fa-envelope-open-text me-2"></i> Templates
                        </a>
                    </li>
                @endif
                @if (module_enabled('social'))
                    <li>
                        <a href="{{ route('campaigns.index', ['type' => 'social']) }}" class="nav-link {{ request()->routeIs('campaigns.*') && request('type') === 'social' ? 'active' : '' }}">
                            <i class="fa fa-share-nodes me-2"></i> Scheduled Posts
                        </a>
                    </li>
                @endif
                @if (module_enabled('marketing') || module_enabled('social'))
                    <li>
                        <a href="{{ route('calendar.index') }}" class="nav-link {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                            <i class="fa fa-calendar-days me-2"></i> Calendar
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="fa fa-user me-2"></i> Profile
                    </a>
                </li>
            @elseif ($isSupportAgent)
                @if (module_enabled('support'))
                    <li>
                        <a href="{{ route('support-tickets.index') }}" class="nav-link {{ request()->routeIs('support-tickets.*') ? 'active' : '' }}">
                            <i class="fa fa-headset me-2"></i> Tickets
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="fa fa-user me-2"></i> Profile
                    </a>
                </li>
            @elseif ($isSupplier)
                @if (module_enabled('products'))
                    <li>
                        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <i class="fa fa-box me-2"></i> My Products
                        </a>
                    </li>
                @endif
                @if (module_enabled('orders'))
                    <li>
                        <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                            <i class="fa fa-inbox me-2"></i> Received Orders
                        </a>
                    </li>
                @endif
                @if (module_enabled('support'))
                    <li>
                        <div class="text-uppercase small fw-semibold text-white-50 px-3 pt-2">Support</div>
                    </li>
                    <li>
                        <a href="{{ route('support-tickets.index') }}" class="nav-link {{ request()->routeIs('support-tickets.*') ? 'active' : '' }}">
                            <i class="fa fa-headset me-2"></i> Tickets
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('support-tickets.create') }}" class="nav-link {{ request()->routeIs('support-tickets.create') ? 'active' : '' }}">
                            <i class="fa fa-ticket me-2"></i> Create Ticket
                        </a>
                    </li>
                @endif
                @if (module_enabled('rfq'))
                    <li>
                        <div class="text-uppercase small fw-semibold text-white-50 px-3 pt-2">RFQ</div>
                    </li>
                    <li>
                        <a href="{{ route('rfqs.index') }}" class="nav-link {{ request()->routeIs('rfqs.*') ? 'active' : '' }}">
                            <i class="fa fa-file-signature me-2"></i> All RFQs
                        </a>
                    </li>
                @endif
                @if (module_enabled('inventory'))
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
                @endif
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
                @if (module_enabled('orders'))
                    <li>
                        <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                            <i class="fa fa-shopping-cart me-2"></i> My Orders
                        </a>
                    </li>
                @endif
                @if (module_enabled('support'))
                    <li>
                        <div class="text-uppercase small fw-semibold text-white-50 px-3 pt-2">Support</div>
                    </li>
                    <li>
                        <a href="{{ route('support-tickets.index') }}" class="nav-link {{ request()->routeIs('support-tickets.*') ? 'active' : '' }}">
                            <i class="fa fa-headset me-2"></i> Tickets
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('support-tickets.create') }}" class="nav-link {{ request()->routeIs('support-tickets.create') ? 'active' : '' }}">
                            <i class="fa fa-ticket me-2"></i> Create Ticket
                        </a>
                    </li>
                @endif
                @if (module_enabled('rfq'))
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
                @endif
                @if (module_enabled('suppliers'))
                    <li>
                        <a href="{{ route('become-supplier') }}" class="nav-link {{ request()->routeIs('become-supplier') ? 'active' : '' }}">
                            <i class="fa fa-truck me-2"></i>
                            @if ($supplierStatus === 'pending')
                                Supplier Application
                            @elseif ($supplierStatus === 'rejected')
                                Reapply as Supplier
                            @else
                                Become a Supplier
                            @endif
                        </a>
                    </li>
                @endif
            @endif
        @endauth
    </ul>
</div>
