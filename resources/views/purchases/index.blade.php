@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header d-print-none mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <div class="mb-1">
                        <ol class="breadcrumb" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Purchases</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title">
                        Purchases
                    </h2>
                </div>
            </div>
        </div>

        <x-alert/>

        @livewire('tables.purchase-table')
    </div>

    <div wire:ignore.self class="modal modal-blur fade" id="modal-purchase-order" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            @livewire('purchase-form')
        </div>
    </div>

    @include('purchases.auxiliary-modals')
</div>
@endsection
