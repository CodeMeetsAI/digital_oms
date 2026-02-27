@include('livewire.customers.create', [
    'isModal' => true,
    'submitLabel' => 'Add',
    'formId' => 'customer-form',
    'formAction' => route('customers.store'),
    'formMethod' => 'POST',
    'redirectUrl' => route('customers.index'),
])

<div class="modal fade" id="modal-create-product" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            @livewire('product-create')
        </div>
    </div>
</div>

<div class="modal fade" id="modal-create-simple-product" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-icon btn-link text-decoration-none p-0 me-2 text-dark" data-bs-target="#modal-create-product" data-bs-toggle="modal" title="Back">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                    </button>
                    <h5 class="modal-title">Create Product</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @livewire('products.create-simple-product', ['isModal' => true])
        </div>
    </div>
</div>

<div class="modal fade" id="modal-create-bundle" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-icon btn-link text-decoration-none p-0 me-2 text-dark" data-bs-target="#modal-create-product" data-bs-toggle="modal" title="Back">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                    </button>
                    <h5 class="modal-title">New Bundle</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @livewire('products.create-bundle', ['isModal' => true])
        </div>
    </div>
</div>

<div class="modal fade" id="modal-create-service" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-icon btn-link text-decoration-none p-0 me-2 text-dark" data-bs-target="#modal-create-product" data-bs-toggle="modal" title="Back">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                    </button>
                    <h5 class="modal-title">New Service</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @livewire('products.create-service-product', ['isModal' => true])
        </div>
    </div>
</div>
