@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Automation & Settings
                </h2>
                <div class="text-muted mt-1">Configure your store, team, and integrations from one central location.</div>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <!-- Personal Card -->
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-blue text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Personal</div>
                                <div class="text-muted">Security & Profile</div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('automation.personal.details') }}" class="btn btn-outline-primary btn-sm w-100">Manage</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Card -->
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-green text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="3" y1="21" x2="21" y2="21" /><line x1="9" y1="8" x2="10" y2="8" /><line x1="9" y1="12" x2="10" y2="12" /><line x1="9" y1="16" x2="10" y2="16" /><line x1="14" y1="8" x2="15" y2="8" /><line x1="14" y1="12" x2="15" y2="12" /><line x1="14" y1="16" x2="15" y2="16" /><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Company</div>
                                <div class="text-muted">Team & Details</div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('automation.company.details') }}" class="btn btn-outline-primary btn-sm w-100">Manage</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Integrations Card -->
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-orange text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="6" height="6" rx="1" /><rect x="14" y="4" width="6" height="6" rx="1" /><rect x="4" y="14" width="6" height="6" rx="1" /><path d="M14 17h6" /><path d="M17 14v6" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Marketplaces</div>
                                <div class="text-muted">Woo, Daraz, etc.</div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('automation.integrations.index') }}" class="btn btn-outline-primary btn-sm w-100">Manage</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- API Management Card -->
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-purple text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="11" width="14" height="10" rx="2" /><circle cx="12" cy="16" r="1" /><path d="M8 11v-5a4 4 0 0 1 8 0" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">API Tokens</div>
                                <div class="text-muted">Generate & Manage</div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('automation.api-management.index') }}" class="btn btn-outline-primary btn-sm w-100">Manage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cards mt-3">
             <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">General Configurations</h3>
                    </div>
                    <div class="card-body">
                         <div class="row g-3">
                            @php
                                $configs = [
                                    ['name' => 'Shipping', 'route' => 'automation.configurations.shipping'],
                                    ['name' => 'Locations', 'route' => 'automation.configurations.locations'],
                                    ['name' => 'Categories', 'route' => 'automation.configurations.categories'],
                                    ['name' => 'Variations', 'route' => 'automation.configurations.variations'],
                                    ['name' => 'Price List', 'route' => 'automation.configurations.price-list'],
                                    ['name' => 'Taxes', 'route' => 'automation.configurations.taxes'],
                                    ['name' => 'Payment Methods', 'route' => 'automation.configurations.payment-methods'],
                                    ['name' => 'Shipping Methods', 'route' => 'automation.configurations.shipping-methods'],
                                ];
                            @endphp
                            @foreach($configs as $c)
                            <div class="col-6 col-md-3">
                                <a href="{{ route($c['route']) }}" class="card card-sm card-link">
                                    <div class="card-body text-center py-3">
                                        <div class="font-weight-medium">{{ $c['name'] }}</div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                         </div>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>
@endsection
