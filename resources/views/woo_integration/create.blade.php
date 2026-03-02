@extends('layouts.app')

@section('content')
<div class="container">
    <h2>WooCommerce Integration</h2>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div style="color:red">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div style="color:red">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/woo-integration-store') }}">
        @csrf
        <div>
            <label>Store Nickname:</label>
            <input type="text" name="store_nickname" value="{{ old('store_nickname') }}" required>
        </div>
        <div>
            <label>API URL:</label>
            <input type="text" name="api_url" value="{{ old('api_url') }}" required>
        </div>
        <div>
            <label>Consumer Key:</label>
            <input type="text" name="consumer_key" value="{{ old('consumer_key') }}" required>
        </div>
        <div>
            <label>Consumer Secret:</label>
            <input type="text" name="consumer_secret" value="{{ old('consumer_secret') }}" required>
        </div>

        <h4>Options:</h4>
        <label><input type="checkbox" name="auto_import_products" value="1"> Auto Import Products</label><br>
        <label><input type="checkbox" name="auto_import_orders" value="1"> Auto Import Orders</label><br>
        <label><input type="checkbox" name="sync_stock" value="1"> Sync Stock</label><br>
        <label><input type="checkbox" name="update_price" value="1"> Update Price</label><br>
        <label><input type="checkbox" name="auto_generate_sku" value="1"> Auto Generate SKU</label><br>
        <label><input type="checkbox" name="push_fulfillment" value="1"> Push Fulfillment</label><br>

        <button type="submit">Save Integration</button>
    </form>

    <h4>Sync Actions:</h4>
    @if(isset($integrations) && count($integrations))
        @foreach($integrations as $integration)
            <div>
                <strong>{{ $integration->store_nickname }}</strong>:
                <a href="{{ url('/woo-sync-products/'.$integration->id) }}">Sync Products</a> |
                <a href="{{ url('/woo-sync-orders/'.$integration->id) }}">Sync Orders</a>
            </div>
        @endforeach
    @else
        <p>No integrations found.</p>
    @endif
</div>
@endsection