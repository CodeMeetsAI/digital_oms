<div class="card">
    <div class="card-body p-0">
        <div class="list-group list-group-flush list-group-transparent">
            <div class="list-group-header">Personal</div>
            <a href="{{ route('automation.personal.details') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('automation.personal.details') ? 'active' : '' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                </span>
                Personal Details
            </a>
            <a href="{{ route('automation.personal.password') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('automation.personal.password') ? 'active' : '' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="11" width="14" height="10" rx="2" /><circle cx="12" cy="16" r="1" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                </span>
                Security
            </a>

            <div class="list-group-header mt-3">Company</div>
            <a href="{{ route('automation.company.details') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('automation.company.details') ? 'active' : '' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="3" y1="21" x2="21" y2="21" /><line x1="9" y1="8" x2="10" y2="8" /><line x1="9" y1="12" x2="10" y2="12" /><line x1="9" y1="16" x2="10" y2="16" /><line x1="14" y1="8" x2="15" y2="8" /><line x1="14" y1="12" x2="15" y2="12" /><line x1="14" y1="16" x2="15" y2="16" /><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" /></svg>
                </span>
                Company Profile
            </a>
            <a href="{{ route('automation.company.team') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('automation.company.team') ? 'active' : '' }}">
                 <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                </span>
                Team Members
            </a>

            <div class="list-group-header mt-3">Integrations</div>
            <a href="{{ route('automation.integrations.index') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('automation.integrations.*') ? 'active' : '' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="6" height="6" rx="1" /><rect x="14" y="4" width="6" height="6" rx="1" /><rect x="4" y="14" width="6" height="6" rx="1" /><path d="M14 17h6" /><path d="M17 14v6" /></svg>
                </span>
                Marketplaces
            </a>
            <a href="{{ route('automation.api-management.index') }}" class="list-group-item list-group-item-action d-flex align-items-center {{ Route::is('automation.api-management.index') ? 'active' : '' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="11" width="14" height="10" rx="2" /><circle cx="12" cy="16" r="1" /><path d="M8 11v-5a4 4 0 0 1 8 0" /></svg>
                </span>
                API Keys
            </a>
        </div>
    </div>
</div>
