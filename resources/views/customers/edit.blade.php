@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-fluid">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title">
                    Edit Customer
                </h2>
            </div>
        </div>

        @include('partials._breadcrumbs', ['model' => $customer])
    </div>
</div>

<div class="page-body">
    <div class="container-fluid">
        @include('livewire.customers.create', [
            'customerCategories' => $customerCategories ?? null,
            'formAction' => route('customers.update', $customer),
            'formMethod' => 'PUT',
            'formId' => 'customer-form',
            'submitLabel' => 'Update',
            'customer' => $customer,
            'redirectUrl' => route('customers.index'),
        ])
    </div>
</div>
@endsection
