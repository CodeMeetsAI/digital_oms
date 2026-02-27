@extends('layouts.tabler')

@section('title', 'Automation Settings')

@section('content')

<style>
/* Top Tabs Styling */
.settings-tabs {
    display: flex;
    border: 1px solid #198754;
    border-radius: 6px;
    overflow: hidden;
}

.settings-tabs .nav-link {
    flex: 1;
    text-align: center;
    border-right: 1px solid #198754;
    color: #198754;
    font-weight: 500;
    background: #fff;
}

.settings-tabs .nav-link:last-child {
    border-right: none;
}

.settings-tabs .nav-link.active {
    background: #198754;
    color: #fff;
}

.settings-card {
    border-radius: 12px;
    border: 1px solid #ddd;
}

.settings-card .card-header {
    background: #fff;
    border-bottom: 1px solid #eee;
    font-weight: 600;
}

.section-title {
    color: #198754;
    font-weight: 600;
}
</style>

<div class="container py-4">

    <h3 class="mb-4">Settings</h3>

    <!-- Tabs -->
    <ul class="nav settings-tabs mb-4" id="settingsTab" role="tablist">
        <li class="nav-item flex-fill">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personal">Personal</button>
        </li>
        <li class="nav-item flex-fill">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#company">Company</button>
        </li>
        <li class="nav-item flex-fill">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#configurations">Configurations</button>
        </li>
        <li class="nav-item flex-fill">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#integrations">Integrations</button>
        </li>
        <li class="nav-item flex-fill">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#api">API Management</button>
        </li>
    </ul>

    <div class="tab-content">

        <!-- PERSONAL -->
        <div class="tab-pane fade show active" id="personal">
            <div class="row">
                <div class="col-md-6">
                    <div class="card settings-card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title mb-3">Personal Details</h5>
                            <hr>
                            <p><strong>Name:</strong> {{ auth()->user()->name ?? 'umar' }}</p>
                            <p><strong>Email:</strong> {{ auth()->user()->email ?? 'example@gmail.com' }}</p>
                            <button class="btn btn-success btn-sm">Edit Personal Details</button>
                        </div>
                    </div>

                    <div class="card settings-card shadow-sm">
                        <div class="card-body">
                            <h5 class="section-title mb-3">Password Details</h5>
                            <hr>
                            <p>********</p>
                            <a href="#" class="text-success fw-bold">Change Password</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card settings-card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title mb-3">Default Details</h5>
                            <hr>
                            <p><strong>Default Location:</strong> Location1</p>
                            <p><strong>Default Customer:</strong> -</p>
                            <button class="btn btn-success btn-sm">Edit Personal Default</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- COMPANY -->
        <div class="tab-pane fade" id="company">
            <div class="row">
                <!-- LEFT SIDE -->
                <div class="col-md-6">

                    <!-- Company Details -->
                    <div class="card settings-card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title mb-3">Company Details</h5>
                            <hr>
                            <div class="mb-2"><strong>Company Name:</strong> -</div>
                            <div class="mb-2"><strong>Phone:</strong> -</div>
                            <div class="mb-2"><strong>Email:</strong> -</div>
                            <div class="mb-2"><strong>Company Address:</strong> -</div>
                            <div class="mb-2"><strong>Country:</strong> -</div>
                            <div class="mb-2"><strong>City:</strong> -</div>
                            <div class="mb-2"><strong>State:</strong> -</div>
                            <div class="mb-2"><strong>Zipcode:</strong> -</div>
                            <div class="mb-2"><strong>Miscellaneous Info:</strong> -</div>

                            <button class="btn btn-success btn-sm mt-3">
                                Edit Company Details
                            </button>
                        </div>
                    </div>

                    <!-- Role Management -->
                    <div class="card settings-card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title mb-3">Role Management</h5>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>Super Admin</strong>
                                    <div class="text-muted small">Super Admin</div>
                                </div>
                                <span class="badge bg-success">Active</span>
                            </div>

                            <!-- Subscription Warning -->
                            <div class="alert alert-warning mt-3 mb-0">
                                You've reached the maximum user limit permitted in your subscription.
                                Please upgrade your package!
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT SIDE -->
                <div class="col-md-6">

                    <!-- Team Members -->
                    <div class="card settings-card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="section-title mb-3">Team Members</h5>
                            <hr>

                            <div class="border rounded p-3 mb-2">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>umar | Super Admin</strong>
                                        <div class="small text-muted">User ID: 1</div>
                                        <div class="small text-muted">umarshabbir.ai@gmail.com</div>
                                    </div>
                                    <span class="badge bg-success align-self-start">Active</span>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-sm">
                                Add Team Member
                            </button>
                        </div>
                    </div>

                    <!-- Notification Settings -->
                    <div class="card settings-card shadow-sm">
                        <div class="card-body">
                            <h5 class="section-title mb-3">Notification Settings</h5>
                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Low Stock</strong>
                                </div>

                                <!-- Toggle Switch -->
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="lowStockToggle">
                                    <label class="form-check-label small text-muted" for="lowStockToggle">
                                        Off
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- CONFIGURATIONS -->
        <div class="tab-pane fade" id="configurations">
            <div class="row">

                @php
                    $configs = [
                        ['title' => 'Shipping', 'desc' => 'User define custom shipping charges for the sales order screen'],
                        ['title' => 'Locations', 'desc' => 'Use locations to track inventory across different spaces in your business (eg: Warehouse A, Warehouse B etc.)'],
                        ['title' => 'Categories', 'desc' => 'Organize your products, Suppliers, Customers, Expenses with categories.'],
                        ['title' => 'Variations', 'desc' => 'Add variations if your products have different sizes, colors etc.'],
                        ['title' => 'Barcodes', 'desc' => 'Save time and avoid errors by setting up barcodes and SKUs of your inventory.'],
                        ['title' => 'Price List', 'desc' => 'Manage your price list by adding, updating, and organizing product prices for quick and accurate selling.'],
                        ['title' => 'Financials', 'desc' => 'Manage charts of accounts, ledgers, and expense journals for better reporting.'],
                        ['title' => 'Taxes', 'desc' => 'Define your taxing schemes to apply different types of taxes on purchase and sales orders.'],
                        ['title' => 'Sales Process Customisation', 'desc' => 'Manage all your sales orders and sales invoices related configurations.'],
                        ['title' => 'Transaction Numbers', 'desc' => 'Define transaction conventions for various modules.'],
                        ['title' => 'Automations', 'desc' => 'Automate every aspect of your business to save time and reduce repetitive work.'],
                        ['title' => 'Payment Methods', 'desc' => 'Define payment methods for orders in the system.'],
                        ['title' => 'Shipping Methods', 'desc' => 'Define shipping methods for orders.'],
                        ['title' => 'Tags', 'desc' => 'Create, update, and maintain order and product tags.'],
                        ['title' => 'Brands', 'desc' => 'Create, update, and maintain product brands.'],
                        ['title' => 'Return Management', 'desc' => 'Create, update, and maintain order item return reasons.'],
                    ];
                @endphp

                @foreach($configs as $config)
                <div class="col-md-6 mb-4">
                    <div class="card settings-card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="section-title mb-2">{{ $config['title'] }}</h5>
                            <p class="text-muted small flex-grow-1">
                                {{ $config['desc'] }}
                            </p>
                            <button class="btn btn-outline-success btn-sm mt-3">
                                Manage {{ $config['title'] }}
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>

        <!-- INTEGRATIONS -->
        <div class="tab-pane fade" id="integrations">
            <div class="container-fluid">

                <!-- CONNECTED SECTION -->
                <div class="card settings-card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="section-title mb-3">Connected</h5>
                        <hr>

                        <div class="border rounded p-3">
                            <strong>Asaan Retail</strong>
                            <div class="small text-muted">Store ID: AR-1</div>
                            <span class="badge bg-success mt-2">Connected</span>
                        </div>
                    </div>
                </div>

                <!-- ALL INTEGRATIONS -->
                <div class="card settings-card shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3">Integrations</h5>
                        <hr>

                        @php
                            $integrations = [
                                // E-commerce
                                ['name' => 'Daraz', 'type' => 'E-commerce'],
                                ['name' => 'WooCommerce', 'type' => 'E-commerce'],
                                ['name' => 'Shopify', 'type' => 'E-commerce'],
                                ['name' => 'Unlinked', 'type' => 'E-commerce'],

                                // Couriers
                                ['name' => 'M&P', 'type' => 'Courier'],
                                ['name' => 'Leopards', 'type' => 'Courier'],
                                ['name' => 'Trax', 'type' => 'Courier'],
                                ['name' => 'TCS', 'type' => 'Courier'],
                                ['name' => 'Call Courier', 'type' => 'Courier'],
                                ['name' => 'Blue EX', 'type' => 'Courier'],
                                ['name' => 'Other Courier', 'type' => 'Courier'],
                                ['name' => 'Rider', 'type' => 'Courier'],
                                ['name' => 'PostEx', 'type' => 'Courier'],
                                ['name' => 'DoDeliver', 'type' => 'Courier'],
                                ['name' => 'Fardar Express', 'type' => 'Courier'],
                                ['name' => 'eCourier', 'type' => 'Courier'],
                                ['name' => 'Smartlane', 'type' => 'Courier'],
                                ['name' => 'ShipNOC', 'type' => 'Courier'],
                                ['name' => 'InstaWorld', 'type' => 'Courier'],
                                ['name' => 'Daewoo Express', 'type' => 'Courier'],
                                ['name' => 'MXC', 'type' => 'Courier'],
                                ['name' => 'Pathao Courier', 'type' => 'Courier'],
                                ['name' => 'PentaExpress', 'type' => 'Courier'],
                                ['name' => 'Digidokaan', 'type' => 'Courier'],
                                ['name' => 'Courier Next', 'type' => 'Courier'],
                                ['name' => 'Camel Courier', 'type' => 'Courier'],
                                ['name' => 'Aramex', 'type' => 'Courier'],
                                ['name' => 'Fly Courier', 'type' => 'Courier'],
                                ['name' => 'Dakia Courier', 'type' => 'Courier'],
                                ['name' => 'Bouraq', 'type' => 'Courier'],
                                ['name' => 'Pakistan Post', 'type' => 'Courier'],
                                ['name' => 'Barqraftar Courier', 'type' => 'Courier'],
                                ['name' => 'Stallion Deliveries', 'type' => 'Courier'],
                                ['name' => 'Tranzo', 'type' => 'Courier'],

                                // Communication
                                ['name' => 'Monty Mobile', 'type' => 'Communication'],
                                ['name' => 'WhatsApp', 'type' => 'Communication'],
                                ['name' => 'IVR Calls', 'type' => 'Communication'],

                                // FBR
                                ['name' => 'FBR POS', 'type' => 'FBR POS'],
                            ];

                            function slugify($text) {
                                return strtolower(preg_replace('/[^A-Za-z0-9]+/', '-', $text));
                            }

                            // Special slug mapping
                            $slugMap = [
                                'Daraz' => 'daraz',
                                'WooCommerce' => 'woo',
                                'Leopards' => 'leopard',
                            ];
                        @endphp

                        <div class="row">
                            @foreach($integrations as $integration)
                                <div class="col-md-4 mb-4">
                                    <div class="border rounded p-3 h-100 d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <strong>{{ $integration['name'] }}</strong>
                                            <span class="badge bg-secondary">{{ $integration['type'] }}</span>
                                        </div>

                                        <div class="mt-auto">
                                            @php
                                                $slug = $slugMap[$integration['name']] ?? slugify($integration['name']);
                                            @endphp
                                            <a href="{{ route('integrations.show', $slug) }}" 
                                               class="btn btn-outline-success btn-sm w-100">
                                               Configure
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- API MANAGEMENT -->
        <div class="tab-pane fade" id="api">
            <div class="card settings-card shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3">API Management</h5>
                    <hr>
                    <p>Generate and manage your API keys.</p>
                    <button class="btn btn-danger btn-sm">Generate API Key</button>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection