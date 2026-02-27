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
                            <li class="breadcrumb-item"><a href="#">Sales</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Customers</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title">
                        Customers
                    </h2>
                </div>
            </div>
        </div>

        @livewire('tables.customer-table')
    </div>
</div>
@endsection
