@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-fluid">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title">
                    New Customer
                </h2>
            </div>
        </div>

        @include('partials._breadcrumbs')
    </div>
</div>

<div class="page-body">
    <div class="container-fluid">
        @include('livewire.customers.create', [
            'customerCategories' => $customerCategories ?? null,
            'formAction' => route('customers.store'),
            'formMethod' => 'POST',
            'formId' => 'customer-form',
            'submitLabel' => 'Add',
            'customer' => null,
            'redirectUrl' => route('customers.index'),
        ])
    </div>
</div>
@endsection
