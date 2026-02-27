@php($customerCategories = $customerCategories ?? \App\Models\CustomerCategory::all())
@php($customer = $customer ?? null)
@php($formAction = $formAction ?? route('customers.store'))
@php($formMethod = $formMethod ?? 'POST')
@php($formId = $formId ?? 'customer-form')
@php($submitLabel = $submitLabel ?? 'Save')
@php($redirectUrl = $redirectUrl ?? route('customers.index'))
@php($isModal = $isModal ?? false)

@if($isModal)
<div class="modal modal-blur fade" id="modal-create-customer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
@endif

<form id="{{ $formId }}" action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(strtoupper($formMethod) !== 'POST')
        @method($formMethod)
    @endif
    <div class="card">
        <div class="card-body">
            <div id="customer-form-errors" class="alert alert-danger d-none"></div>
            <input type="hidden" name="address" id="customer-address" value="{{ old('address', $customer->address ?? '') }}">
            <div class="row">
                <div class="col-lg-6 border-end">
                    <h4 class="mb-3">Personal Details</h4>
                    <div class="mb-3">
                        <label class="form-label required">Customer Name:</label>
                        <input type="text" class="form-control" name="name" id="customer-name" placeholder="Customer Name" value="{{ old('name', $customer->name ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category:</label>
                        <div class="input-group">
                            <select class="form-select" name="category_id" id="customer-category">
                                <option value="">Default</option>
                                @foreach($customerCategories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $customer->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-success" type="button" aria-label="Add Category" data-bs-toggle="modal" data-bs-target="#modal-customer-category">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Opening Balance</label>
                            <input type="number" step="0.01" class="form-control" name="opening_balance" placeholder="0" value="{{ old('opening_balance', $customer->opening_balance ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="opening_balance_type">
                                <option value="receivable" @selected(old('opening_balance_type', $customer->opening_balance_type ?? 'receivable') === 'receivable')>Receivable</option>
                                <option value="payable" @selected(old('opening_balance_type', $customer->opening_balance_type ?? '') === 'payable')>Payable</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Discount (%)</label>
                        <input type="number" step="0.01" class="form-control" name="discount" placeholder="0" value="{{ old('discount', $customer->discount ?? '') }}">
                    </div>

                    <hr class="my-4">

                    <h4 class="mb-3">Billing Address</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control" name="billing_name" id="billing_name" placeholder="name" value="{{ old('billing_name', $customer->billing_name ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                    </svg>
                                </span>
                                <input type="text" class="form-control" name="billing_phone" id="billing_phone" placeholder="+92 301 2345678" value="{{ old('billing_phone', $customer->billing_phone ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address Line #1:</label>
                        <input type="text" class="form-control" name="billing_address_line_1" id="billing_address_line_1" placeholder="#1" value="{{ old('billing_address_line_1', $customer->billing_address_line_1 ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line #2:</label>
                        <input type="text" class="form-control" name="billing_address_line_2" id="billing_address_line_2" placeholder="#2" value="{{ old('billing_address_line_2', $customer->billing_address_line_2 ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line #3:</label>
                        <input type="text" class="form-control" name="billing_address_line_3" id="billing_address_line_3" placeholder="#3" value="{{ old('billing_address_line_3', $customer->billing_address_line_3 ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line #4:</label>
                        <input type="text" class="form-control" name="billing_address_line_4" id="billing_address_line_4" placeholder="#4" value="{{ old('billing_address_line_4', $customer->billing_address_line_4 ?? '') }}">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Country:</label>
                            <select class="form-select" name="billing_country" id="billing_country">
                                <option value="">Select Country</option>
                                <option value="Pakistan" @selected(old('billing_country', $customer->billing_country ?? '') === 'Pakistan')>Pakistan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City:</label>
                            <select class="form-select" name="billing_city" id="billing_city">
                                <option value="">Select City</option>
                                <option value="Karachi" @selected(old('billing_city', $customer->billing_city ?? '') === 'Karachi')>Karachi</option>
                                <option value="Lahore" @selected(old('billing_city', $customer->billing_city ?? '') === 'Lahore')>Lahore</option>
                                <option value="Islamabad" @selected(old('billing_city', $customer->billing_city ?? '') === 'Islamabad')>Islamabad</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h4 class="mb-3">Contact Details</h4>
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" id="customer-email" placeholder="Email" value="{{ old('email', $customer->email ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number:</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                   <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                </svg>
                            </span>
                            <input type="text" class="form-control" name="phone" id="customer-phone" placeholder="+92 301 2345678" value="{{ old('phone', $customer->phone ?? '') }}">
                        </div>
                        <div class="form-text text-end">Copy to All</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">CNIC: <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="12" r="9"></circle><line x1="12" y1="8" x2="12.01" y2="8"></line><polyline points="11 12 12 12 12 16 13 16"></polyline></svg></label>
                            <input type="text" class="form-control" name="cnic" id="customer-cnic" placeholder="xxxxx-xxxxxxx-x" value="{{ old('cnic', $customer->cnic ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NTN: <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="12" r="9"></circle><line x1="12" y1="8" x2="12.01" y2="8"></line><polyline points="11 12 12 12 12 16 13 16"></polyline></svg></label>
                            <input type="text" class="form-control" name="ntn" id="customer-ntn" placeholder="Number" value="{{ old('ntn', $customer->ntn ?? '') }}">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Shipping Address</h4>
                        <label class="form-check form-check-inline mb-0">
                            <input class="form-check-input" type="checkbox" id="copy-billing-to-shipping">
                            <span class="form-check-label">Same as billing</span>
                        </label>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control" name="shipping_name" id="shipping_name" placeholder="name" value="{{ old('shipping_name', $customer->shipping_name ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                       <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                       <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                    </svg>
                                </span>
                                <input type="text" class="form-control" name="shipping_phone" id="shipping_phone" placeholder="+92 301 2345678" value="{{ old('shipping_phone', $customer->shipping_phone ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address Line #1:</label>
                        <input type="text" class="form-control" name="shipping_address_line_1" id="shipping_address_line_1" placeholder="#1" value="{{ old('shipping_address_line_1', $customer->shipping_address_line_1 ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line #2:</label>
                        <input type="text" class="form-control" name="shipping_address_line_2" id="shipping_address_line_2" placeholder="#2" value="{{ old('shipping_address_line_2', $customer->shipping_address_line_2 ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line #3:</label>
                        <input type="text" class="form-control" name="shipping_address_line_3" id="shipping_address_line_3" placeholder="#3" value="{{ old('shipping_address_line_3', $customer->shipping_address_line_3 ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line #4:</label>
                        <input type="text" class="form-control" name="shipping_address_line_4" id="shipping_address_line_4" placeholder="#4" value="{{ old('shipping_address_line_4', $customer->shipping_address_line_4 ?? '') }}">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Country:</label>
                            <select class="form-select" name="shipping_country" id="shipping_country">
                                <option value="">Select Country</option>
                                <option value="Pakistan" @selected(old('shipping_country', $customer->shipping_country ?? '') === 'Pakistan')>Pakistan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City:</label>
                            <select class="form-select" name="shipping_city" id="shipping_city">
                                <option value="">Select City</option>
                                <option value="Karachi" @selected(old('shipping_city', $customer->shipping_city ?? '') === 'Karachi')>Karachi</option>
                                <option value="Lahore" @selected(old('shipping_city', $customer->shipping_city ?? '') === 'Lahore')>Lahore</option>
                                <option value="Islamabad" @selected(old('shipping_city', $customer->shipping_city ?? '') === 'Islamabad')>Islamabad</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <a href="{{ route('customers.index') }}" class="btn btn-link link-secondary">Cancel</a>
            <button type="submit" class="btn btn-success" id="customer-submit-button">{{ $submitLabel }}</button>
        </div>
    </div>
</form>

@if($isModal)
            </div>
        </div>
    </div>
</div>
@endif

<div class="modal modal-blur fade" id="modal-customer-category" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <form id="customer-category-form" class="modal-content" action="{{ route('customer-categories.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">New Customer Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="customer-category-errors" class="alert alert-danger d-none"></div>
                <div class="mb-3">
                    <label class="form-label required">Category Name</label>
                    <input type="text" class="form-control" name="name" id="customer-category-name" placeholder="Category name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Existing Categories</label>
                    <ul class="list-group" id="customer-category-list">
                        @foreach($customerCategories as $category)
                            <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $category->id }}">
                                <span>{{ $category->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success ms-auto" id="customer-category-submit-button">Add</button>
            </div>
        </form>
    </div>
</div>

@push('page-scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const customerForm = document.getElementById('{{ $formId }}');
        const customerErrors = document.getElementById('customer-form-errors');
        const customerSubmit = document.getElementById('customer-submit-button');
        const categorySelect = document.getElementById('customer-category');
        const redirectUrl = @json($redirectUrl);
        const isModal = @json($isModal);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const addressInput = document.getElementById('customer-address');

        const categoryForm = document.getElementById('customer-category-form');
        const categoryErrors = document.getElementById('customer-category-errors');
        const categoryName = document.getElementById('customer-category-name');
        const categoryList = document.getElementById('customer-category-list');
        const categorySubmit = document.getElementById('customer-category-submit-button');

        const copyCheckbox = document.getElementById('copy-billing-to-shipping');
        const billingFields = {
            name: document.getElementById('billing_name'),
            phone: document.getElementById('billing_phone'),
            line1: document.getElementById('billing_address_line_1'),
            line2: document.getElementById('billing_address_line_2'),
            line3: document.getElementById('billing_address_line_3'),
            line4: document.getElementById('billing_address_line_4'),
            country: document.getElementById('billing_country'),
            city: document.getElementById('billing_city'),
        };
        const shippingFields = {
            name: document.getElementById('shipping_name'),
            phone: document.getElementById('shipping_phone'),
            line1: document.getElementById('shipping_address_line_1'),
            line2: document.getElementById('shipping_address_line_2'),
            line3: document.getElementById('shipping_address_line_3'),
            line4: document.getElementById('shipping_address_line_4'),
            country: document.getElementById('shipping_country'),
            city: document.getElementById('shipping_city'),
        };

        const clearErrors = (form, alert) => {
            alert.classList.add('d-none');
            alert.innerHTML = '';
            form.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
        };

        const showErrors = (alert, errors) => {
            alert.innerHTML = Object.values(errors).flat().map((msg) => `<div>${msg}</div>`).join('');
            alert.classList.remove('d-none');
        };

        const copyBillingToShipping = () => {
            shippingFields.name.value = billingFields.name.value;
            shippingFields.phone.value = billingFields.phone.value;
            shippingFields.line1.value = billingFields.line1.value;
            shippingFields.line2.value = billingFields.line2.value;
            shippingFields.line3.value = billingFields.line3.value;
            shippingFields.line4.value = billingFields.line4.value;
            shippingFields.country.value = billingFields.country.value;
            shippingFields.city.value = billingFields.city.value;
        };

        if (copyCheckbox) {
            copyCheckbox.addEventListener('change', () => {
                if (copyCheckbox.checked) {
                    copyBillingToShipping();
                } else {
                    Object.values(shippingFields).forEach((field) => field.value = '');
                }
            });

            Object.values(billingFields).forEach((field) => {
                field.addEventListener('input', () => {
                    if (copyCheckbox.checked) {
                        copyBillingToShipping();
                    }
                });
            });
        }

        if (addressInput && billingFields.line1) {
            const syncAddress = () => {
                addressInput.value = billingFields.line1.value;
            };
            billingFields.line1.addEventListener('input', syncAddress);
            syncAddress();
        }

        if (customerForm) {
            customerForm.addEventListener('submit', async (event) => {
                event.preventDefault();
                clearErrors(customerForm, customerErrors);
                customerSubmit.disabled = true;

                const formData = new FormData(customerForm);

                try {
                    const response = await fetch(customerForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                        },
                        body: formData,
                    });

                    if (response.status === 422) {
                        const data = await response.json();
                        Object.keys(data.errors || {}).forEach((field) => {
                            const input = customerForm.querySelector(`[name="${field}"]`);
                            if (input) input.classList.add('is-invalid');
                        });
                        showErrors(customerErrors, data.errors || {});
                        return;
                    }

                    if (!response.ok) {
                        showErrors(customerErrors, { error: ['Unable to save customer.'] });
                        return;
                    }

                    const data = await response.json().catch(() => ({}));

                    if (isModal) {
                        customerForm.reset();
                        const modalEl = document.getElementById('modal-create-customer');
                        const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modalInstance.hide();
                        if (data.customer) {
                            document.dispatchEvent(new CustomEvent('customer-created', { detail: { customer: data.customer } }));
                        }
                    } else {
                        window.location.href = redirectUrl;
                    }
                } catch (error) {
                    showErrors(customerErrors, { error: ['Unable to save customer.'] });
                } finally {
                    customerSubmit.disabled = false;
                }
            });
        }

        if (categoryForm) {
            categoryForm.addEventListener('submit', async (event) => {
                event.preventDefault();
                clearErrors(categoryForm, categoryErrors);
                categorySubmit.disabled = true;

                const formData = new FormData(categoryForm);

                try {
                    const response = await fetch(categoryForm.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                        },
                        body: formData,
                    });

                    if (response.status === 422) {
                        const data = await response.json();
                        const input = categoryForm.querySelector('[name="name"]');
                        if (input) input.classList.add('is-invalid');
                        showErrors(categoryErrors, data.errors || {});
                        return;
                    }

                    if (!response.ok) {
                        showErrors(categoryErrors, { error: ['Unable to save category.'] });
                        return;
                    }

                    const data = await response.json();
                    if (data.category) {
                        const option = document.createElement('option');
                        option.value = data.category.id;
                        option.textContent = data.category.name;
                        categorySelect.appendChild(option);
                        categorySelect.value = data.category.id;

                        const listItem = document.createElement('li');
                        listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                        listItem.dataset.id = data.category.id;
                        listItem.innerHTML = `<span>${data.category.name}</span>`;
                        categoryList.prepend(listItem);
                    }

                    categoryForm.reset();
                    const modalEl = document.getElementById('modal-customer-category');
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modalInstance.hide();
                } catch (error) {
                    showErrors(categoryErrors, { error: ['Unable to save category.'] });
                } finally {
                    categorySubmit.disabled = false;
                }
            });
        }
    });
</script>
@endpush
