<div class="card">
    <div class="card-body p-0">
        <div class="list-group list-group-flush list-group-transparent">
            <div class="list-group-header">Business Reports</div>
            
            <a href="{{ route('reports.sales') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('reports.sales') ? 'active' : '' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="3" y1="21" x2="21" y2="21" /><path d="M3 10a4 4 0 1 1 4 4h10a4 4 0 1 1 4 -4" /></svg>
                </span>
                Sales Reports
            </a>
            
            <a href="{{ route('reports.purchases') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('reports.purchases') ? 'active' : '' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3" /><line x1="12" y1="12" x2="20" y2="7.5" /><line x1="12" y1="12" x2="12" y2="21" /><line x1="12" y1="12" x2="4" y2="7.5" /></svg>
                </span>
                Purchase Reports
            </a>

            <a href="{{ route('reports.inventory') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('reports.inventory') ? 'active' : '' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="6" height="6" rx="1" /><rect x="14" y="4" width="6" height="6" rx="1" /><rect x="4" y="14" width="6" height="6" rx="1" /><rect x="14" y="14" width="6" height="6" rx="1" /></svg>
                </span>
                Inventory Levels
            </a>

            <div class="list-group-header mt-3">Platform & Finance</div>
            
            <a href="{{ route('reports.integrations') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('reports.integrations') ? 'active' : '' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 10v6a3 3 0 0 0 3 3h10a3 3 0 0 0 3 -3v-6" /><rect x="4" y="4" width="16" height="6" rx="2" /><line x1="12" y1="16" x2="12" y2="16.01" /></svg>
                </span>
                Integrations Setup
            </a>
            
            <a href="{{ route('reports.financials') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('reports.financials') ? 'active' : '' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11" /><line x1="8" y1="8" x2="12" y2="8" /><line x1="8" y1="12" x2="12" y2="12" /><line x1="8" y1="16" x2="12" y2="16" /></svg>
                </span>
                Financial Summary
            </a>

            <a href="{{ route('reports.returns') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('reports.returns') ? 'active' : '' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" /></svg>
                </span>
                Returns Analysis
            </a>
        </div>
    </div>
</div>
