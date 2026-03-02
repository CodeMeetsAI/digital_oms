@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <h2 class="page-title">Marketplace Integrations</h2>
        <div class="text-muted mt-1">Connect your OMS to ecommerce platforms to sync orders and products.</div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                @livewire('integrations.integration-manager')
            </div>
        </div>
    </div>
</div>
@endsection
