@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Marketplace Integrations
                </h2>
                <div class="text-muted mt-1">Connect your ecommerce platforms to sync orders and inventory.</div>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-3">
                @include('automation._sidebar')
            </div>
            <div class="col-md-9">
                <div class="row row-cards">
                    @php
                        $available = [
                            ['name' => 'Daraz', 'slug' => 'daraz', 'icon' => 'https://img.icons8.com/color/48/000000/daraz.png', 'status' => 'disconnected'],
                            ['name' => 'WooCommerce', 'slug' => 'woocommerce', 'icon' => 'https://img.icons8.com/color/48/000000/woocommerce.png', 'status' => 'disconnected'],
                            ['name' => 'Shopify', 'slug' => 'shopify', 'icon' => 'https://img.icons8.com/color/48/000000/shopify.png', 'status' => 'disconnected'],
                            ['name' => 'WordPress', 'slug' => 'wordpress', 'icon' => 'https://img.icons8.com/color/48/000000/wordpress.png', 'status' => 'disconnected'],
                        ];
                    @endphp

                    @foreach($available as $app)
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-status-top bg-blue"></div>
                            <div class="card-body py-4">
                                <img src="{{ $app['icon'] }}" alt="{{ $app['name'] }}" class="mb-3" style="height: 48px;">
                                <h3 class="card-title mb-1">{{ $app['name'] }}</h3>
                                <div class="text-muted small mb-3">Sync orders & stock</div>
                                <a href="{{ route('automation.integrations.show', $app['slug']) }}" class="btn btn-primary w-100">
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
@endsection
