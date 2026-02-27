@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    {{ __('Suppliers') }}
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-fluid">
        <x-alert/>
        @livewire('tables.supplier-table')
    </div>
</div>

@endsection

@push('page-scripts')
<script>
    function openCategoryModal() {
        const modalEl = document.getElementById('modal-category');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
</script>
@endpush
