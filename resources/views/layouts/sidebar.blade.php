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

    $makeItem = static fn (string $label, string $icon, string $route, string $pattern) => [
        'type' => 'link',
        'label' => $label,
        'icon' => $icon,
        'route' => $route,
        'active' => request()->routeIs($pattern),
    ];

    $makeGroup = static fn (string $key, string $label, string $icon, array $items) => [
        'key' => $key,
        'label' => $label,
        'icon' => $icon,
        'items' => $items,
        'active' => collect($items)->contains(fn (array $item): bool => $item['active']),
    ];

    $groups = [];

    if (in_array($normalizedRole, ['admin', 'marketing_manager', 'support_agent'], true)) {
        $groups[] = $makeGroup('overview', 'Overview', 'fa-gauge-high', [
            ['type' => 'link', 'label' => 'Dashboard', 'icon' => 'fa-gauge-high', 'route' => $dashboardRoute, 'active' => $dashboardActive],
        ]);

        if ($user->hasRole('admin')) {
            $operations = [];
            if (module_enabled('products')) {
                $operations[] = $makeItem('Products', 'fa-box', route('products.index'), 'products.*');
            }
            if (module_enabled('inventory')) {
                $operations[] = $makeItem('Inventory', 'fa-warehouse', route('inventory.index'), 'inventory.*');
            }
            if (module_enabled('orders')) {
                $operations[] = $makeItem('Orders', 'fa-shopping-cart', route('orders.index'), 'orders.*');
            }
            if (module_enabled('suppliers')) {
                $operations[] = $makeItem('Suppliers', 'fa-truck', route('admin.suppliers.index'), 'admin.suppliers.*');
            }
            if (module_enabled('rfq')) {
                $operations[] = $makeItem('RFQ', 'fa-file-signature', route('rfqs.index'), 'rfqs.*');
            }
            if (module_enabled('workflow')) {
                $operations[] = $makeItem('Automation', 'fa-bolt', route('automation.index'), 'automation.*');
            }
            if ($operations !== []) {
                $groups[] = $makeGroup('operations', 'Operations', 'fa-layer-group', $operations);
            }

            $growth = [];
            if (module_enabled('marketing') || module_enabled('social')) {
                $growth[] = $makeItem('Campaigns', 'fa-bullhorn', route('campaigns.index'), 'campaigns.*');
            }
            if (module_enabled('crm')) {
                $growth[] = $makeItem('Customers', 'fa-address-book', route('customers.index'), 'customers.*');
                $growth[] = $makeItem('Leads', 'fa-filter-circle-dollar', route('leads.index'), 'leads.*');
            }
            if ($growth !== []) {
                $groups[] = $makeGroup('growth', 'Growth', 'fa-chart-line', $growth);
            }

            $system = [
                $makeItem('Users', 'fa-users', route('admin.users.index'), 'admin.users.*'),
                $makeItem('Settings', 'fa-gear', route('admin.modules.index'), 'admin.modules.*'),
            ];
            $groups[] = $makeGroup('system', 'System', 'fa-sliders', $system);
        } elseif ($user->hasRole('marketing_manager')) {
            $marketing = [];
            if (module_enabled('marketing') || module_enabled('social')) {
                $marketing[] = $makeItem('Campaigns', 'fa-bullhorn', route('campaigns.index'), 'campaigns.*');
                $marketing[] = $makeItem('Calendar', 'fa-calendar-days', route('calendar.index'), 'calendar.*');
            }
            if ($marketing !== []) {
                $groups[] = $makeGroup('marketing', 'Marketing', 'fa-wand-magic-sparkles', $marketing);
            }

            if (module_enabled('crm')) {
                $groups[] = $makeGroup('crm', 'CRM', 'fa-address-book', [
                    $makeItem('Customers', 'fa-address-book', route('customers.index'), 'customers.*'),
                ]);
            }
        } elseif ($user->hasRole('support_agent') && module_enabled('support')) {
            $groups[] = $makeGroup('support', 'Support', 'fa-headset', [
                $makeItem('Tickets', 'fa-headset', route('support-tickets.index'), 'support-tickets.*'),
            ]);
        }
    } elseif ($user?->hasRole('supplier')) {
        $groups[] = $makeGroup('overview', 'Overview', 'fa-gauge-high', [
            ['type' => 'link', 'label' => 'Dashboard', 'icon' => 'fa-gauge-high', 'route' => $dashboardRoute, 'active' => $dashboardActive],
        ]);

        $catalog = [];
        if (module_enabled('products')) {
            $catalog[] = $makeItem('Products', 'fa-box', route('products.index'), 'products.*');
        }
        if (module_enabled('inventory')) {
            $catalog[] = $makeItem('Inventory', 'fa-warehouse', route('inventory.index'), 'inventory.*');
        }
        if ($catalog !== []) {
            $groups[] = $makeGroup('catalog', 'Catalog', 'fa-boxes-stacked', $catalog);
        }

        $sales = [];
        if (module_enabled('orders')) {
            $sales[] = $makeItem('Orders', 'fa-shopping-cart', route('orders.index'), 'orders.*');
        }
        if (module_enabled('rfq')) {
            $sales[] = $makeItem('RFQs', 'fa-file-signature', route('rfqs.index'), 'rfqs.*');
        }
        if ($sales !== []) {
            $groups[] = $makeGroup('sales', 'Sales', 'fa-chart-column', $sales);
        }

        $account = [];
        if (module_enabled('support')) {
            $account[] = $makeItem('Tickets', 'fa-headset', route('support-tickets.index'), 'support-tickets.*');
        }
        $account[] = $makeItem('Profile', 'fa-user', route('profile.edit'), 'profile.edit');
        $groups[] = $makeGroup('account', 'Account', 'fa-user-gear', $account);
    } else {
        $groups[] = $makeGroup('overview', 'Overview', 'fa-gauge-high', [
            ['type' => 'link', 'label' => 'Dashboard', 'icon' => 'fa-gauge-high', 'route' => $dashboardRoute, 'active' => $dashboardActive],
        ]);

        $purchasing = [
            $makeItem('Profile', 'fa-user', route('profile.edit'), 'profile.edit'),
        ];
        if (module_enabled('orders')) {
            $purchasing[] = $makeItem('My Orders', 'fa-shopping-cart', route('orders.index'), 'orders.*');
        }
        if (module_enabled('rfq')) {
            $purchasing[] = $makeItem('All RFQs', 'fa-file-signature', route('rfqs.index'), 'rfqs.*');
            $purchasing[] = $makeItem('Create RFQ', 'fa-file-circle-plus', route('rfqs.create'), 'rfqs.create');
        }
        if (module_enabled('suppliers')) {
            $supplierLabel = $supplierStatus === 'rejected' ? 'Reapply as Supplier' : 'Become a Supplier';
            $purchasing[] = ['type' => 'link', 'label' => $supplierLabel, 'icon' => 'fa-truck', 'route' => route('become-supplier'), 'active' => request()->routeIs('become-supplier')];
        }
        $groups[] = $makeGroup('purchasing', 'Purchasing', 'fa-basket-shopping', $purchasing);

        if (module_enabled('support')) {
            $groups[] = $makeGroup('support', 'Support', 'fa-headset', [
                $makeItem('Tickets', 'fa-headset', route('support-tickets.index'), 'support-tickets.*'),
            ]);
        }
    }
@endphp

<div class="sidebar p-3" id="sidebar">
    <a href="{{ $dashboardRoute }}" class="sidebar-brand text-decoration-none">
        <img src="{{ asset('images/plexora-logo.png') }}" alt="Plexora ERP Logo" class="sidebar-brand-logo">
        <div class="sidebar-brand-copy">
            <span class="sidebar-brand-title">Plexora ERP</span>
            <span class="sidebar-brand-subtitle">Business Control Hub</span>
        </div>
    </a>

    @auth
        <div class="sidebar-nav">
            @foreach ($groups as $group)
                <div class="sidebar-group">
                    <button
                        class="sidebar-group-toggle {{ $group['active'] ? '' : 'collapsed' }}"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#sidebar-group-{{ $group['key'] }}"
                        aria-expanded="{{ $group['active'] ? 'true' : 'false' }}"
                        aria-controls="sidebar-group-{{ $group['key'] }}"
                    >
                        <span class="sidebar-group-label">
                            <i class="fa {{ $group['icon'] }} me-2"></i>{{ $group['label'] }}
                        </span>
                        <i class="fa fa-chevron-down sidebar-group-arrow"></i>
                    </button>

                    <div class="collapse {{ $group['active'] ? 'show' : '' }}" id="sidebar-group-{{ $group['key'] }}">
                        <ul class="nav flex-column sidebar-subnav">
                            @foreach ($group['items'] as $item)
                                <li>
                                    <a href="{{ $item['route'] }}" class="nav-link {{ $item['active'] ? 'active' : '' }}">
                                        <i class="fa {{ $item['icon'] }} me-2"></i>{{ $item['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @endauth
</div>
