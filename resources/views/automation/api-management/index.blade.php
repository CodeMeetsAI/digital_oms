@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    API Management
                </h2>
                <div class="text-muted mt-1">Manage API keys for external access to your OMS resources.</div>
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
                @livewire('automation.api-keys-manager')
            </div>
        </div>
    </div>
</div>
@endsection
