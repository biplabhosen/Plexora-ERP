<div class="sidebar p-3" id="sidebar">

    <h4 class="text-white mb-4">Plexora ERP</h4>

    <ul class="nav flex-column gap-2">

        <li>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa fa-gauge-high me-2"></i> Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="fa fa-user me-2"></i> Profile
            </a>
        </li>

        <li>
            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="fa fa-box me-2"></i> Products
            </a>
        </li>

        <li>
            <a href="#" class="nav-link">
                <i class="fa fa-shopping-cart me-2"></i> Orders
            </a>
        </li>

        <li>
            <a href="#" class="nav-link">
                <i class="fa fa-users me-2"></i> CRM
            </a>
        </li>

        <li>
            <a href="#" class="nav-link">
                <i class="fa fa-bullhorn me-2"></i> Campaigns
            </a>
        </li>

        <li>
            <a href="#" class="nav-link">
                <i class="fa fa-cogs me-2"></i> Automation
            </a>
        </li>

    </ul>

</div>
