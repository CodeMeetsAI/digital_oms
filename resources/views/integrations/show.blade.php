@extends('layouts.tabler')

@section('content')
<div class="container py-4">

    <h2>{{ ucfirst($integration->name ?? 'Integration') }} Integration</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('integrations.store', $integration->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Store Details -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header">Store Details</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Store Nickname *</label>
                    <input type="text" class="form-control" name="store_nickname" placeholder="Store Nickname" value="{{ $userIntegration->store_nickname ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="store_name" placeholder="Name" value="{{ $userIntegration->store_name ?? '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="text" class="form-control" name="contact_number" placeholder="+92 301 2345678" value="{{ $userIntegration->contact_number ?? '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="Email address" value="{{ $userIntegration->email ?? '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Store Image</label>
                    <input type="file" class="form-control" name="store_image">
                    @if(isset($userIntegration->store_image))
                        <img src="{{ asset('storage/'.$userIntegration->store_image) }}" alt="Store Image" class="mt-2" style="width:100px;">
                    @endif
                </div>
            </div>
        </div>

        <!-- API Details -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header">API Details</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">API Url *</label>
                    <input type="text" class="form-control" name="api_url" placeholder="API Url" value="{{ $userIntegration->api_url ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">API Key *</label>
                    <input type="text" class="form-control" name="api_key" placeholder="API Key" value="{{ $userIntegration->api_key ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">API Secret *</label>
                    <input type="text" class="form-control" name="api_secret" placeholder="API Secret" value="{{ $userIntegration->api_secret ?? '' }}" required>
                </div>

                <!-- Checkboxes -->
                @php
                    $checkboxes = [
                        'push_fulfil_status' => 'Push Fulfilment Status to '.$integration->name,
                        'pull_delivery_status' => 'Pull Delivery Status from '.$integration->name,
                        'sync_stock' => 'Sync Stock to '.$integration->name,
                        'auto_import_orders' => 'Auto Import Orders from '.$integration->name,
                        'update_price' => 'Update Price on '.$integration->name,
                        'update_product_on_import' => 'On Import, Update Product on Asaan Retail'
                    ];
                @endphp

                @foreach($checkboxes as $field => $label)
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="{{ $field }}" id="{{ $field }}" {{ isset($userIntegration->$field) && $userIntegration->$field ? 'checked' : '' }}>
                        <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Customer Category & FBD -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header">Customer Category & Fulfil FBD Orders</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Customer Category</label>
                    <select class="form-select" name="customer_category">
                        <option value="">Select Category</option>
                        <option value="retail" {{ (isset($userIntegration->customer_category) && $userIntegration->customer_category=='retail')?'selected':'' }}>Retail</option>
                        <option value="wholesale" {{ (isset($userIntegration->customer_category) && $userIntegration->customer_category=='wholesale')?'selected':'' }}>Wholesale</option>
                        <option value="vip" {{ (isset($userIntegration->customer_category) && $userIntegration->customer_category=='vip')?'selected':'' }}>VIP</option>
                    </select>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="auto_import_products" id="auto_import_products" {{ isset($userIntegration->auto_import_products) && $userIntegration->auto_import_products ? 'checked' : '' }}>
                    <label class="form-check-label" for="auto_import_products">
                        Auto Import Products from {{ $integration->name }}
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="auto_generate_missing_sku" id="auto_generate_missing_sku" {{ isset($userIntegration->auto_generate_missing_sku) && $userIntegration->auto_generate_missing_sku ? 'checked' : '' }}>
                    <label class="form-check-label" for="auto_generate_missing_sku">
                        On Import, Auto-generate missing SKU on Asaan Retail
                    </label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save Configuration</button>
    </form>

</div>
@endsection