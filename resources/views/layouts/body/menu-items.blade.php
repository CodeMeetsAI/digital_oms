<li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dashboard') }}">
        <span class="nav-link-icon d-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dashboard" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M13.45 11.55l2.05 -2.05" />
                <path d="M6.4 20a9 9 0 1 1 11.2 0z" />
            </svg>
        </span>
        <span class="nav-link-title">
            Dashboard
        </span>
    </a>
</li>

<!-- Sales -->
<li class="nav-item dropdown {{ request()->is('orders*', 'quotations*', 'customers*') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle" href="#navbar-sales" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M17 17h-11v-14h-2" />
                <path d="M6 5l14 1l-1 7h-13" />
            </svg>
        </span>
        <span class="nav-link-title">
            Sales
        </span>
    </a>
    <div class="dropdown-menu">
        <div class="dropdown-menu-columns">
            <div class="dropdown-menu-column">
                <a class="dropdown-item" href="{{ route('orders.index') }}">Orders</a>
                <a class="dropdown-item" href="{{ route('quotations.index') }}">Quotations</a>
                <a class="dropdown-item" href="{{ route('customers.index') }}">Customers</a>
            </div>
        </div>
    </div>
</li>

<!-- Purchasing -->
<li class="nav-item dropdown {{ request()->is('purchases*', 'suppliers*') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle" href="#navbar-purchasing" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                <path d="M12.5 17h-6.5v-14h-2" />
                <path d="M6 5l14 1l-.86 6.017m-2.64 .983h-10.5" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
            </svg>
        </span>
        <span class="nav-link-title">
            Purchasing
        </span>
    </a>
    <div class="dropdown-menu">
        <div class="dropdown-menu-columns">
            <div class="dropdown-menu-column">
                <a class="dropdown-item" href="{{ route('purchases.index') }}">Purchases</a>
                <a class="dropdown-item" href="{{ route('suppliers.index') }}">Suppliers</a>
            </div>
        </div>
    </div>
</li>

<!-- Inventory -->
<li class="nav-item dropdown {{ request()->is('products*', 'categories*', 'units*') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle" href="#navbar-inventory" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-packages" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                <path d="M2 13.5v5.5l5 3" />
                <path d="M7 16.545l5 -3.03" />
                <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                <path d="M12 19l5 3" />
                <path d="M17 16.5l5 -3" />
                <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5" />
                <path d="M7 5.03v5.455" />
                <path d="M12 8l5 -3" />
            </svg>
        </span>
        <span class="nav-link-title">
            Inventory
        </span>
    </a>
    <div class="dropdown-menu">
        <div class="dropdown-menu-columns">
            <div class="dropdown-menu-column">
                <a class="dropdown-item" href="{{ route('products.index') }}">Products</a>
                <a class="dropdown-item" href="{{ route('categories.index') }}">Categories</a>
                <a class="dropdown-item" href="{{ route('units.index') }}">Units</a>
            </div>
        </div>
    </div>
</li>

<!-- Financials -->
<li class="nav-item dropdown {{ request()->routeIs('financials.*') ? 'active' : '' }}">
    <a class="nav-link dropdown-toggle" href="#navbar-financials" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-line" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 19l16 0" />
                <path d="M4 15l4 -6l4 2l4 -5l4 4" />
            </svg>
        </span>
        <span class="nav-link-title">
            Financials
        </span>
    </a>
    <div class="dropdown-menu">
        <div class="dropdown-menu-columns">
            <div class="dropdown-menu-column">
                <a class="dropdown-item" href="#">Overview</a>
                <a class="dropdown-item {{ request()->routeIs('financials.chart-of-accounts') ? 'active' : '' }}" href="{{ route('financials.chart-of-accounts') }}">Chart of Accounts</a>
            </div>
        </div>
    </div>
</li>

<!-- Automations -->
<li class="nav-item {{ request()->routeIs('automation.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('automation.index') }}">
        <span class="nav-link-icon d-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-robot" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M7 7h10a2 2 0 0 1 2 2v1l1 1v3l-1 1v3a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-3l-1 -1v-3l1 -1v-1a2 2 0 0 1 2 -2z" />
                <path d="M10 16h4" />
                <circle cx="8.5" cy="11.5" r=".5" fill="currentColor" />
                <circle cx="15.5" cy="11.5" r=".5" fill="currentColor" />
                <path d="M9 7l-1 -4" />
                <path d="M15 7l1 -4" />
            </svg>
        </span>
        <span class="nav-link-title">
            Automations
        </span>
    </a>
</li>

<!-- Reports -->
<li class="nav-item">
    <a class="nav-link" href="#">
        <span class="nav-link-icon d-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" />
                <path d="M18 14v4h4" />
                <path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" />
                <path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                <path d="M8 11h4" />
                <path d="M8 15h3" />
            </svg>
        </span>
        <span class="nav-link-title">
            Reports
        </span>
    </a>
</li>

<!-- Template -->
<li class="nav-item">
    <a class="nav-link" href="#">
        <span class="nav-link-icon d-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-dashboard" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 4h6v8h-6z" />
                <path d="M4 16h6v4h-6z" />
                <path d="M14 12h6v8h-6z" />
                <path d="M14 4h6v4h-6z" />
            </svg>
        </span>
        <span class="nav-link-title">
            Template
        </span>
    </a>
</li>

<!-- Documents -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#navbar-documents" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
        <span class="nav-link-icon d-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
            </svg>
        </span>
        <span class="nav-link-title">
            Documents
        </span>
    </a>
    <div class="dropdown-menu">
        <div class="dropdown-menu-columns">
            <div class="dropdown-menu-column">
                <a class="dropdown-item" href="#">Invoices</a>
            </div>
        </div>
    </div>
</li>

<!-- Import -->
<li class="nav-item">
    <a class="nav-link" href="#">
        <span class="nav-link-icon d-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                <path d="M7 11l5 5l5 -5" />
                <path d="M12 4l0 12" />
            </svg>
        </span>
        <span class="nav-link-title">
            Import
        </span>
    </a>
</li>

<!-- Export -->
<li class="nav-item">
    <a class="nav-link" href="#">
        <span class="nav-link-icon d-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                <path d="M7 9l5 -5l5 5" />
                <path d="M12 4l0 12" />
            </svg>
        </span>
        <span class="nav-link-title">
            Export
        </span>
    </a>
</li>

@php
    // Settings moved to sidebar footer in navbar.blade.php
@endphp