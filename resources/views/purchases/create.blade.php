@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <x-alert/>

        <div class="row row-cards">
            <div class="col-lg-12">
                @livewire('purchase-form')
            </div>
        </div>
    </div>
    @include('purchases.auxiliary-modals')
</div>
@endsection
