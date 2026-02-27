@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                    </svg>
                    Settings
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-header p-0">
                <ul class="nav nav-tabs border-0 w-100" data-bs-toggle="tabs" style="display: flex; flex-wrap: nowrap;">
                    @php
                        $activeTab = request()->get('tab', 'integrations');
                    @endphp
                    <li class="nav-item flex-fill" role="presentation">
                        <a href="#tabs-personal" class="nav-link border-end py-3 fw-bold text-center {{ $activeTab == 'personal' ? 'active' : '' }}" data-bs-toggle="tab" role="tab" style="color: #00965e;">Personal</a>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <a href="#tabs-company" class="nav-link border-end py-3 fw-bold text-center {{ $activeTab == 'company' ? 'active' : '' }}" data-bs-toggle="tab" role="tab" style="color: #00965e;">Company</a>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <a href="#tabs-configurations" class="nav-link border-end py-3 fw-bold text-center {{ $activeTab == 'configurations' ? 'active' : '' }}" data-bs-toggle="tab" role="tab" style="color: #00965e;">Configurations</a>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <a href="#tabs-integrations" class="nav-link py-3 fw-bold text-center {{ $activeTab == 'integrations' ? 'active' : '' }}" data-bs-toggle="tab" role="tab" style="{{ $activeTab == 'integrations' ? 'background-color: #00965e; color: white;' : 'color: #00965e;' }}">Integrations</a>
                    </li>
                    <li class="nav-item flex-fill" role="presentation">
                        <a href="#tabs-api" class="nav-link py-3 fw-bold text-center {{ $activeTab == 'api' ? 'active' : '' }}" data-bs-toggle="tab" role="tab" style="color: #00965e;">API management</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane fade {{ $activeTab == 'personal' ? 'active show' : '' }}" id="tabs-personal" role="tabpanel">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card shadow-none border mb-3">
                                        <div class="card-body text-center">
                                            <h3 class="card-title mb-3">{{ __('Profile Image') }}</h3>
                                            <div class="mb-3">
                                                <img
                                                    class="img-account-profile rounded-circle mb-2"
                                                    src="{{ $user->photo ? route('profile.photo', ['filename' => $user->photo]) : asset('assets/img/demo/user-placeholder.svg') }}"
                                                    id="image-preview"
                                                    style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #eee;"
                                                />
                                            </div>
                                            <div class="small font-italic text-muted mb-3">JPG or PNG no larger than 1 MB</div>
                                            <input class="form-control @error('photo') is-invalid @enderror" type="file" id="image" name="photo" accept="image/*" onchange="previewImage();">
                                            @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="card shadow-none border mb-3">
                                        <div class="card-body">
                                            <h3 class="card-title mb-4">{{ __('Personal Details') }}</h3>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <x-input name="name" value="{{ old('name', $user->name) }}" :required="true" />
                                                </div>
                                                <div class="col-md-6">
                                                    <x-input name="username" value="{{ old('username', $user->username) }}" :required="true" />
                                                </div>
                                                <div class="col-12">
                                                    <x-input name="email" label="Email address" value="{{ old('email', $user->email) }}" :required="true" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end bg-transparent border-top-0">
                                            <x-button.save type="submit">{{ __('Update Profile') }}</x-button.save>
                                        </div>
                                    </div>

                                    <div class="card shadow-none border">
                                        <div class="card-header bg-transparent">
                                            <h3 class="card-title">{{ __('Change Password') }}</h3>
                                        </div>
                                        <x-form action="{{ route('password.update') }}" method="PUT">
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <x-input type="password" name="current_password" label="Current Password" required />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <x-input type="password" name="password" label="New Password" required />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <x-input type="password" name="password_confirmation" label="Confirm Password" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-end bg-transparent border-top-0">
                                                <x-button type="submit">{{ __('Save Password') }}</x-button>
                                            </div>
                                        </x-form>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'company' ? 'active show' : '' }}" id="tabs-company" role="tabpanel">
                        <div class="card shadow-none border">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Company Information</h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <x-input name="company_name" label="Company Name" value="My Awesome Company" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-input name="tax_id" label="Tax ID / VAT Number" value="123456789" />
                                    </div>
                                    <div class="col-12">
                                        <x-input name="address" label="Company Address" value="123 Business St, Tech City" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-input name="city" label="City" value="Tech City" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-input name="country" label="Country" value="USA" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-input name="zip" label="Zip Code" value="12345" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end bg-transparent border-top-0">
                                <x-button.save type="submit">Update Company</x-button.save>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'configurations' ? 'active show' : '' }}" id="tabs-configurations" role="tabpanel">
                        <div class="card shadow-none border">
                            <div class="card-body">
                                <h3 class="card-title mb-4">Configurations</h3>
                                <div class="space-y-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notify_email" checked>
                                        <label class="form-check-label" for="notify_email">Email Notifications</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notify_orders" checked>
                                        <label class="form-check-label" for="notify_orders">New Order Alerts</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="dark_mode">
                                        <label class="form-check-label" for="dark_mode">Dark Mode</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end bg-transparent border-top-0">
                                <x-button.save type="submit">Save Configurations</x-button.save>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'integrations' ? 'active show' : '' }}" id="tabs-integrations" role="tabpanel">
                        <div class="mb-4">
                            <h4 class="mb-3 d-flex align-items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                    <path d="M9 12l2 2l4 -4"></path>
                                </svg>
                                Connected
                            </h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card border shadow-none" style="border-radius: 12px;">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ asset('assets/img/integrations/asaan-retail.png') }}" alt="Asaan Retail" style="height: 60px;">
                                                    <div>
                                                        <div class="fw-bold d-flex align-items-center gap-1">
                                                            Unlinked
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M9 6l6 6l-6 6"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="text-success small fw-bold">Asaan Retail</div>
                                                        <div class="text-muted smaller" style="font-size: 0.7rem;">Store ID: AR-1 <i class="ti ti-copy"></i></div>
                                                        <div class="text-muted smaller" style="font-size: 0.7rem;">Order Tracker <i class="ti ti-copy"></i></div>
                                                    </div>
                                                </div>
                                                <div class="text-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M17.004 3.31l.117 .007a1 1 0 0 1 .808 .322l3.523 3.523l.094 .11a1 1 0 0 1 .045 1.26l-9 12a1 1 0 0 1 -1.417 .181l-6 -4.5a1 1 0 0 1 1.206 -1.6l4.98 3.734l8.202 -10.936a1 1 0 0 1 .439 -.332z" fill="currentColor" stroke-width="0"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h4 class="mb-3 d-flex align-items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rocket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 13a8 8 0 0 1 7 7a6 6 0 0 0 3 -5a9 9 0 0 0 6 -8a3 3 0 0 0 -3 -3a9 9 0 0 0 -8 6a6 6 0 0 0 -5 3"></path>
                                    <path d="M7 14a6 6 0 0 0 -7 2a6 6 0 0 0 2 7a6 6 0 0 0 5 -9"></path>
                                    <path d="M15 9m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                </svg>
                                Integrations
                            </h4>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card border shadow-none" style="border-radius: 12px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal-daraz">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                 <div class="p-2 rounded" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                                    <img src="{{ asset('assets/img/icons/daraz.png') }}" alt="Daraz" style="max-width: 100%; max-height: 100%;">
                                                </div>
                                                <div>
                                                    <div class="fw-bold d-flex align-items-center gap-1">
                                                        Daraz
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M9 6l6 6l-6 6"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="text-muted smaller" style="font-size: 0.75rem;"><i class="ti ti-shopping-cart"></i> E-commerce</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border shadow-none" style="border-radius: 12px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal-shopify">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                 <div class="p-2 rounded" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                                    <img src="{{ asset('assets/img/icons/shopify.png') }}" alt="WooCommerce" style="max-width: 100%; max-height: 100%;">
                                                </div>
                                                <div>
                                                    <div class="fw-bold d-flex align-items-center gap-1">
                                                        Shopify
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M9 6l6 6l-6 6"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="text-muted smaller" style="font-size: 0.75rem;"><i class="ti ti-shopping-cart"></i> E-commerce</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border shadow-none" style="border-radius: 12px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal-woocommerce">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="p-2 rounded" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                                    <img src="{{ asset('assets/img/icons/woo.png') }}" alt="WooCommerce" style="max-width: 100%; max-height: 100%;">
                                                </div>
                                                <div>
                                                    <div class="fw-bold d-flex align-items-center gap-1">
                                                        WooCommerce
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M9 6l6 6l-6 6"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="text-muted smaller" style="font-size: 0.75rem;"><i class="ti ti-shopping-cart"></i> E-commerce</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5 class="mb-2 d-flex align-items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-truck-delivery" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 10l1 0"></path>
                                        <path d="M3 14l1 0"></path>
                                        <path d="M4 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path d="M13 17h-5"></path>
                                        <path d="M13 8h-8v9"></path>
                                        <path d="M15 8h5l1 3v6h-2"></path>
                                        <path d="M6 19h7"></path>
                                        <path d="M19 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                    </svg>
                                    Couriers
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="card border shadow-none" style="border-radius: 12px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal-leopards">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="p-2 rounded" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                                        <img src="{{ asset('assets/img/icons/leopards.png') }}" alt="Leopards" style="max-width: 100%; max-height: 100%;">
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold d-flex align-items-center gap-1">
                                                            Leopards
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M9 6l6 6l-6 6"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="text-muted smaller" style="font-size: 0.75rem;"><i class="ti ti-truck"></i> Courier</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-api" role="tabpanel">
                        <div class="card shadow-none border">
                            <div class="card-body">
                                <h3 class="card-title mb-4">API Management</h3>
                                <div class="mb-4">
                                    <label class="form-label">API Secret Key</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" value="sk_test_51Mzxxxxxxxxxxxxxxxxxxxxx" readonly>
                                        <button class="btn btn-outline-secondary" type="button">Copy</button>
                                        <button class="btn btn-outline-secondary" type="button">Reveal</button>
                                    </div>
                                    <div class="form-hint">Use this key to authenticate your requests to our API.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Public Key</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="pk_test_51Mzxxxxxxxxxxxxxxxxxxxxx" readonly>
                                        <button class="btn btn-outline-secondary" type="button">Copy</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end bg-transparent border-top-0">
                                <button class="btn btn-danger">Regenerate Keys</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('page-scripts')
    <script src="{{ asset('assets/js/img-preview.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addNewBtn = document.getElementById('add-new-category');
            const categoryList = document.getElementById('category-list');
            const saveBtn = document.getElementById('save-categories');
            const wooDropdown = document.getElementById('woo_customer_category');
            const testConnBtn = document.getElementById('test-connection-btn');
            
            if (testConnBtn) {
                testConnBtn.addEventListener('click', async function() {
                    const form = document.querySelector('#modal-woocommerce form');
                    const apiUrl = form.querySelector('input[name="api_url"]').value;
                    const key = form.querySelector('input[name="consumer_key"]').value;
                    const secret = form.querySelector('input[name="consumer_secret"]').value;
                    try {
                        const res = await fetch('{{ route('integrations.woocommerce.test') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ api_url: apiUrl, consumer_key: key, consumer_secret: secret })
                        });
                        const data = await res.json();
                        if (data.ok) {
                            if (window.notyf) notyf.success('Connection established successfully!');
                        } else {
                            if (window.notyf) notyf.error('Connection failed. Status: ' + data.status);
                        }
                    } catch (e) {
                        if (window.notyf) notyf.error('Connection test error.');
                    }
                });
            }

            const testDarazBtn = document.getElementById('test-connection-daraz');
            if (testDarazBtn) {
                testDarazBtn.addEventListener('click', async function() {
                    const form = document.querySelector('#modal-daraz form');
                    const apiUrl = form.querySelector('select[name="api_url"]').value;
                    const key = form.querySelector('input[name="api_key"]').value;
                    const secret = form.querySelector('input[name="api_secret"]').value;
                    try {
                        const res = await fetch('{{ route('integrations.daraz.test') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ api_url: apiUrl, api_key: key, api_secret: secret })
                        });
                        const data = await res.json();
                        if (data.ok) {
                            if (window.notyf) notyf.success('Daraz connection successful');
                        } else {
                            if (window.notyf) notyf.error('Daraz connection failed. Status: ' + data.status);
                        }
                    } catch (e) {
                        if (window.notyf) notyf.error('Daraz test error.');
                    }
                });
            }

            const testLeopardsBtn = document.getElementById('test-connection-leopards');
            if (testLeopardsBtn) {
                testLeopardsBtn.addEventListener('click', async function() {
                    const form = document.querySelector('#modal-leopards form');
                    const payload = {
                        account_nickname: form.querySelector('input[name="account_nickname"]').value,
                        api_key: form.querySelector('input[name="api_key"]').value,
                        api_password: form.querySelector('input[name="api_password"]').value,
                        shipper_id: form.querySelector('input[name="shipper_id"]').value
                    };
                    try {
                        const res = await fetch('{{ route('integrations.leopards.test') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(payload)
                        });
                        const data = await res.json();
                        if (data.ok) {
                            if (window.notyf) notyf.success('Leopards connection successful');
                        } else {
                            if (window.notyf) notyf.error('Leopards connection failed. Status: ' + data.status);
                        }
                    } catch (e) {
                        if (window.notyf) notyf.error('Leopards test error.');
                    }
                });
            }

            // Add new category input field
            addNewBtn.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.className = 'category-row';
                newRow.innerHTML = '<input type="text" class="form-control mb-2 category-input" placeholder="Enter category name">';
                categoryList.appendChild(newRow);
                newRow.querySelector('input').focus();
            });

            // Save categories and update WooCommerce dropdown
            saveBtn.addEventListener('click', async function() {
                const inputs = document.querySelectorAll('.category-input');
                const savePromises = [];
                const newCategories = [];
                
                saveBtn.disabled = true;
                saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

                for (const input of inputs) {
                    const value = input.value.trim();
                    if (value && !input.disabled && value !== 'Default') {
                        // Prepare the promise for saving
                        const promise = fetch('{{ route("categories.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({ name: value })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                newCategories.push(data.category);
                                return data.category;
                            } else {
                                throw new Error(data.message || 'Failed to save category');
                            }
                        })
                        .catch(error => {
                            console.error('Error saving category:', error);
                            if (window.notyf) {
                                notyf.error('Error saving "' + value + '": ' + error.message);
                            }
                        });
                        
                        savePromises.push(promise);
                    }
                }

                try {
                    await Promise.all(savePromises);
                    
                    // Update WooCommerce dropdown with new categories
                    newCategories.forEach(cat => {
                        const option = document.createElement('option');
                        option.value = cat.id; // Use ID as value for DB storage
                        option.text = cat.name;
                        wooDropdown.add(option);
                        // Select the last added category
                        wooDropdown.value = cat.id;
                    });

                    // Close category modal
                    const catModalEl = document.getElementById('modal-customer-categories');
                    const modal = bootstrap.Modal.getInstance(catModalEl);
                    if (modal) {
                        modal.hide();
                    }
                    
                    // Show success message
                    if (window.notyf) {
                        notyf.success('Categories saved to database and dropdown updated!');
                    }
                } catch (err) {
                    console.error('Final save error:', err);
                } finally {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = 'Save Changes';
                }
            });

            // Standard Bootstrap fix for multiple modals: ensure scrollbar stays when one modal closes but another is still open
            const catModalEl = document.getElementById('modal-customer-categories');
            catModalEl.addEventListener('hidden.bs.modal', function () {
                // Remove all newly added category rows (rows with inputs that are not disabled)
                const newRows = catModalEl.querySelectorAll('.category-row input:not([disabled])');
                newRows.forEach(input => {
                    input.parentElement.remove();
                });

                if (document.querySelectorAll('.modal.show').length > 0) {
                    document.body.classList.add('modal-open');
                }
            });
        });
    </script>
@endpush

<!-- WooCommerce Integration Modal -->
<div class="modal modal-blur fade" id="modal-woocommerce" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <img src="{{ asset('assets/img/icons/woo.png') }}" alt="WooCommerce" style="height: 40px;">
                    <div class="d-flex align-items-center gap-3">
                        <a href="#" class="text-muted text-decoration-none small d-flex align-items-center gap-1 d-none d-sm-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-help-circle" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                <path d="M12 17l0 .01"></path>
                                <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4"></path>
                            </svg>
                            Help Center
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body pt-2">
                <form action="{{ route('integrations.woocommerce.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label required fw-bold">Store Nickname</label>
                            <input type="text" class="form-control" name="store_nickname" placeholder="Name">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Contact Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white px-2">
                                    <img src="https://flagcdn.com/w20/pk.png" width="20" alt="PK" class="me-1">
                                    +92-
                                </span>
                                <input type="text" class="form-control" name="contact_number" placeholder="301 2345678">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Email address">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Store Image</label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="border rounded p-1 text-center bg-light flex-shrink-0" style="width: 60px; height: 60px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 0.5rem; line-height: 1;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M15 8h.01"></path>
                                        <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"></path>
                                        <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5"></path>
                                        <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"></path>
                                    </svg>
                                    <span class="d-none d-md-inline">NO IMAGE</span>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control form-control-sm" name="store_image">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-dark border-2 mb-4">
                        <h5 class="mb-2 fw-bold">API Details</h5>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label required fw-bold">API Url</label>
                            <input type="text" class="form-control" name="api_url" placeholder="http://www.woocommerce.com/">
                            <div class="text-danger smaller mt-1">Please enter URL with "https://" or "http://"</div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label required fw-bold">Consumer Key</label>
                            <input type="text" class="form-control" name="consumer_key" placeholder="Please Enter">
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <label class="form-label required fw-bold">Consumer Secret</label>
                            <input type="text" class="form-control" name="consumer_secret" placeholder="Please Enter">
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5 class="fw-bold">Advanced</h5>
                    </div>

                    <div class="row g-4 mb-4">
                        <!-- Left Column -->
                        <div class="col-md-6 col-lg-4">
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="push_fulfillment">Push Fulfilment Status to woocommerce</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="push_fulfillment" name="push_fulfillment" value="1">
                                </div>
                                <div class="text-muted smaller">Asaan Retail will update the order status in woocommerce whenever order status changes in Asaan Retail. <a href="#" class="text-success">Learn More</a></div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="auto_import_orders">Auto Import Orders from woocommerce</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="auto_import_orders" name="auto_import_orders" value="1">
                                </div>
                                <div class="text-muted smaller">Asaan Retail will automatically import orders from woocommerce to Asaan Retail every 15 Minutes. <a href="#" class="text-success">Learn More</a></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold mb-1">Customer Category:</label>
                                <div class="d-flex gap-2">
                                    <select class="form-select" name="customer_category" id="woo_customer_category">
                                        <option value="default">Default</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-success px-2" data-bs-toggle="modal" data-bs-target="#modal-customer-categories">+</button>
                                </div>
                                <div class="text-muted smaller mt-1">Select which customer category will be mapped to this sales channel.</div>
                            </div>
                        </div>

                        <!-- Middle Column -->
                        <div class="col-md-6 col-lg-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-2">Take Stock</label>
                                <div class="space-y-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="take_stock_mode" id="stock_all" value="all" checked>
                                        <label class="form-check-label" for="stock_all">From all your Asaan Retail locations</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="take_stock_mode" id="stock_specific" value="specific">
                                        <label class="form-check-label" for="stock_specific">From Specific Location</label>
                                    </div>
                                    <input type="text" class="form-control form-control-sm mt-2" name="take_stock_location" placeholder="Search location...">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="update_price">Update Price on woocommerce</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="update_price" name="update_price" value="1">
                                </div>
                                <div class="text-muted smaller">Price changes in Asaan Retail do not sync automatically with woocommerce. A manual update or trigger is required. <a href="#" class="text-success">Learn More</a></div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="auto_import_products">Auto Import Products from woocommerce</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="auto_import_products" name="auto_import_products" value="1">
                                </div>
                                <div class="text-muted smaller">Asaan Retail will automatically fetch products from woocommerce at the given time. <a href="#" class="text-success">Learn More</a></div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-12 col-lg-4">
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="sync_stock">Sync Stock to woocommerce</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="sync_stock" name="sync_stock" value="1">
                                </div>
                                <div class="text-muted smaller">Asaan Retail will automatically sync the inventory levels to woocommerce every 15 Minutes. <a href="#" class="text-success">Learn More</a></div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="update_product_on_import">On Import, Update Product on Asaan Retail</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="update_product_on_import" name="update_product_on_import" value="1">
                                </div>
                                <div class="text-muted smaller">When the user import products from woocommerce, on finding a similar SKU, the product details (Name, and Description) will be automatically updated on Asaan Retail. <a href="#" class="text-success">Learn More</a></div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="auto_generate_sku">On Import, Auto-generate missing SKU on Asaan Retail</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="auto_generate_sku" name="auto_generate_sku" value="1">
                                </div>
                                <div class="text-muted smaller">When the user import products from woocommerce, If a SKU is missing on woocommerce, the product SKU will be auto-generated on Asaan Retail. <a href="#" class="text-success">Learn More</a></div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 justify-content-center mt-4 pb-3">
                        <div class="col-6 col-md-4">
                            <button type="submit" class="btn btn-success w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #00965e; border-color: #00965e;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M8 11v-4a4 4 0 1 1 8 0v4"></path>
                                </svg>
                                <span class="d-none d-sm-inline">Authorize</span>
                                <span class="d-inline d-sm-none">Auth</span>
                            </button>
                        </div>
                        <div class="col-6 col-md-4">
                            <button type="button" class="btn btn-success w-100 py-2 d-flex align-items-center justify-content-center gap-2" id="test-connection-btn" style="background-color: #00965e; border-color: #00965e;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-link" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 15l6 -6"></path>
                                    <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072L18 13"></path>
                                    <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071L6 11"></path>
                                </svg>
                                <span class="d-none d-sm-inline">Test Connection</span>
                                <span class="d-inline d-sm-none">Test</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Customer Categories Modal -->
<div class="modal modal-blur fade" id="modal-customer-categories" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Customer Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-end mb-3">
                    <button type="button" class="btn btn-warning fw-bold d-inline-flex align-items-center gap-1" id="add-new-category" style="background-color: #ffde00; border-color: #ffde00; color: black;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        New
                    </button>
                </div>
                <div id="category-list" class="space-y-2">
                    <div class="category-row">
                        <input type="text" class="form-control mb-2 category-input" value="Default" readonly disabled>
                    </div>
                    @foreach($categories as $category)
                        <div class="category-row">
                            <input type="text" class="form-control mb-2 category-input" value="{{ $category->name }}" readonly disabled>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-success px-5 py-2 fw-bold w-100 w-sm-auto" id="save-categories" style="background-color: #00965e; border-color: #00965e;">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link {
        transition: all 0.3s ease;
        border-radius: 0;
        margin-bottom: 0;
    }
    .nav-tabs .nav-link:hover {
        background-color: #f8f9fa;
    }
    .nav-tabs .nav-link.active {
        background-color: #00965e !important;
        color: white !important;
        border-color: #00965e !important;
    }
    .smaller {
        font-size: 0.8rem;
    }
    .card-header .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }
    /* Custom style for the active tab to match the image precisely */
    .nav-link.active {
        background-color: #00965e !important;
        color: white !important;
    }
    /* Simple Bootstrap fix for nested modals z-index */
    .modal:nth-of-type(even) {
        z-index: 1062 !important;
    }
    .modal-backdrop:nth-of-type(even) {
        z-index: 1061 !important;
    }
    #modal-daraz,
    #modal-leopards {
        z-index: 1062;
    }
    #modal-daraz .modal-content,
    #modal-daraz .modal-dialog,
    #modal-leopards .modal-content,
    #modal-leopards .modal-dialog {
        pointer-events: auto;
    }
</style>
@endsection
@push('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const testDarazBtn = document.getElementById('test-connection-daraz');
    if (testDarazBtn) {
        testDarazBtn.addEventListener('click', async function() {
            const form = document.querySelector('#modal-daraz form');
            const apiUrl = form.querySelector('select[name="api_url"]').value;
            const key = form.querySelector('input[name="api_key"]').value;
            const secret = form.querySelector('input[name="api_secret"]').value;
            try {
                const res = await fetch('{{ route('integrations.daraz.test') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ api_url: apiUrl, api_key: key, api_secret: secret })
                });
                const data = await res.json();
                if (data.ok) {
                    if (window.notyf) notyf.success('Daraz connection successful');
                } else {
                    if (window.notyf) notyf.error('Daraz connection failed. Status: ' + data.status);
                }
            } catch (e) {
                if (window.notyf) notyf.error('Daraz test error.');
            }
        });
    }

    const testLeopardsBtn = document.getElementById('test-connection-leopards');
    if (testLeopardsBtn) {
        testLeopardsBtn.addEventListener('click', async function() {
            const form = document.querySelector('#modal-leopards form');
            const payload = {
                account_nickname: form.querySelector('input[name="account_nickname"]').value,
                api_key: form.querySelector('input[name="api_key"]').value,
                api_password: form.querySelector('input[name="api_password"]').value,
                shipper_id: form.querySelector('input[name=\"shipper_id\"]').value
            };
            try {
                const res = await fetch('{{ route('integrations.leopards.test') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                if (data.ok) {
                    if (window.notyf) notyf.success('Leopards connection successful');
                } else {
                    if (window.notyf) notyf.error('Leopards connection failed. Status: ' + data.status);
                }
            } catch (e) {
                if (window.notyf) notyf.error('Leopards test error.');
            }
        });
    }
});
</script>
@endpush

<div class="modal modal-blur fade" id="modal-daraz" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <img src="{{ asset('assets/img/integrations/daraz.png') }}" alt="Daraz" style="height: 40px;">
                    <div class="d-flex align-items-center gap-3">
                        <a href="#" class="text-muted text-decoration-none small d-flex align-items-center gap-1 d-none d-sm-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-help-circle" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                <path d="M12 17l0 .01"></path>
                                <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4"></path>
                            </svg>
                            Help Center
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body pt-2">
                <form action="{{ route('integrations.daraz.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label required fw-bold">Store Nickname</label>
                            <input type="text" class="form-control" name="store_nickname" placeholder="Name">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Contact Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white px-2">+92-</span>
                                <input type="text" class="form-control" name="contact_number" placeholder="301 2345678">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Email address">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Store Image</label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="border rounded p-1 text-center bg-light flex-shrink-0" style="width: 60px; height: 60px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 0.5rem; line-height: 1;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M15 8h.01"></path><path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"></path><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5"></path><path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"></path></svg>
                                    <span class="d-none d-md-inline">NO IMAGE</span>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control form-control-sm" name="store_image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4" style="border-bottom: 2px dotted #111;">
                        <h5 class="mb-2 fw-bold">API Details</h5>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label required fw-bold">API Url</label>
                            <select class="form-select" name="api_url">
                                <option value="https://api.daraz.com.np/">Nepal</option>
                                <option value="https://api.daraz.com.bd/">Bangladesh</option>
                                <option value="https://api.daraz.com.mm/">Myanmar</option>
                                <option value="https://api.daraz.pk/">Pakistan</option>
                                <option value="https://api.daraz.lk/">Sri Lanka</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required fw-bold">API Secret</label>
                            <input type="text" class="form-control" name="api_secret" placeholder="Please Enter">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required fw-bold">API Key</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="api_key" placeholder="Please Enter">
                                <button type="button" class="btn btn-success" style="background-color: #00965e; border-color: #00965e;">Auth</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3"><h5 class="fw-bold">Advanced</h5></div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6 col-lg-4">
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="push_fulfillment_dz">Push Fulfilment Status to daraz</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="push_fulfillment_dz" name="push_fulfillment" value="1">
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="sync_stock_dz">Sync Stock to daraz</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="sync_stock_dz" name="sync_stock" value="1">
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="auto_import_products_dz">Auto Import Products from daraz</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="auto_import_products_dz" name="auto_import_products" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-2">Take Stock</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="take_stock_mode" id="stock_all_dz" value="all" checked>
                                    <label class="form-check-label" for="stock_all_dz">From all your Asaan Retail locations</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="take_stock_mode" id="stock_specific_dz" value="specific">
                                    <label class="form-check-label" for="stock_specific_dz">From Specific Location</label>
                                </div>
                                <input type="text" class="form-control form-control-sm mt-2" name="take_stock_location" placeholder="Search location...">
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="update_price_dz">Update Price on daraz</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="update_price_dz" name="update_price" value="1">
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="auto_import_orders_dz">Auto Import Orders from daraz</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="auto_import_orders_dz" name="auto_import_orders" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="pull_delivery_status_dz">Pull Delivery Status from daraz</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="pull_delivery_status_dz" name="pull_delivery_status" value="1">
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="update_product_on_import_dz">On Import, Update Product on Asaan Retail</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="update_product_on_import_dz" name="update_product_on_import" value="1">
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="auto_generate_sku_dz">On Import, Auto-generate missing SKU on Asaan Retail</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="auto_generate_sku_dz" name="auto_generate_sku" value="1">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-1">Fulfil FBD Orders From:</label>
                                <select class="form-select" name="fulfill_fbd_location">
                                    <option value="">Select Location</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-1">Customer Category:</label>
                                <div class="d-flex gap-2">
                                    <select class="form-select" name="customer_category">
                                        <option value="default">Default</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-success px-2" data-bs-toggle="modal" data-bs-target="#modal-customer-categories">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-center mt-4 pb-3">
                        <div class="col-6 col-md-4">
                            <button type="submit" class="btn btn-success w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #00965e; border-color: #00965e;">
                                <span>Authorize</span>
                            </button>
                        </div>
                        <div class="col-6 col-md-4">
                            <button type="button" class="btn btn-success w-100 py-2 d-flex align-items-center justify-content-center gap-2" id="test-connection-daraz" style="background-color: #00965e; border-color: #00965e;">
                                <span>Test Connection</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-shopify" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <div class="d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-shopify" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 8l2 -3l10 -3l4 3v14l-10 3l-6 -4z"/>
                        </svg>
                        <span class="fw-bold">Shopify</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body pt-2">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label required fw-bold">Store Nickname</label>
                            <input type="text" class="form-control" name="store_nickname" placeholder="Name">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Contact Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white px-2">+92-</span>
                                <input type="text" class="form-control" name="contact_number" placeholder="301 2345678">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Email address">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Store Image</label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="border rounded p-1 text-center bg-light flex-shrink-0" style="width: 60px; height: 60px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 0.5rem; line-height: 1;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M15 8h.01"></path><path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"></path><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5"></path><path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"></path></svg>
                                    <span class="d-none d-md-inline">NO IMAGE</span>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control form-control-sm" name="store_image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4" style="border-bottom: 2px dotted #111;">
                        <h5 class="mb-2 fw-bold">API Details</h5>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label required fw-bold">Store Domain</label>
                            <input type="text" class="form-control" name="store_domain" placeholder="your-store.myshopify.com">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required fw-bold">Access Token</label>
                            <input type="text" class="form-control" name="access_token" placeholder="Admin API Access Token">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">API Version</label>
                            <select class="form-select" name="api_version">
                                <option value="2024-10">2024-10</option>
                                <option value="2024-07">2024-07</option>
                                <option value="2024-04">2024-04</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-center mt-4 pb-3">
                        <div class="col-6 col-md-4">
                            <button type="submit" class="btn btn-success w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #00965e; border-color: #00965e;">
                                <span>Authorize</span>
                            </button>
                        </div>
                        <div class="col-6 col-md-4">
                            <button type="button" class="btn btn-success w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #00965e; border-color: #00965e;">
                                <span>Test Connection</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-leopards" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <img src="{{ asset('assets/img/icons/leopards.png') }}" alt="Leopards" style="height: 40px;">
                    <div class="d-flex align-items-center gap-3">
                        <a href="#" class="text-muted text-decoration-none small d-flex align-items-center gap-1 d-none d-sm-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-help-circle" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                <path d="M12 17l0 .01"></path>
                                <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4"></path>
                            </svg>
                            Help Center
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body pt-2">
                <form action="{{ route('integrations.leopards.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label required fw-bold">Account Nickname</label>
                            <input type="text" class="form-control" name="account_nickname" placeholder="Please Enter">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label required fw-bold">Courier Companies</label>
                            <select class="form-select" name="courier_company">
                                <option value="Leopards">Leopards</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Please Enter">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Support No</label>
                            <input type="text" class="form-control" name="support_no" placeholder="Please Enter">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Landline No</label>
                            <input type="text" class="form-control" name="landline_no" placeholder="Please Enter">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Please Enter">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Account No</label>
                            <input type="text" class="form-control" name="account_no" placeholder="Please Enter">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-bold">Shipper ID</label>
                            <input type="text" class="form-control" name="shipper_id" placeholder="Please Enter">
                        </div>
                    </div>

                    <div class="mb-3" style="border-bottom: 2px dotted #111;">
                        <h5 class="mb-2 fw-bold">API Details</h5>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label required fw-bold">API Key</label>
                            <input type="text" class="form-control" name="api_key" placeholder="Please Enter">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required fw-bold">API Password</label>
                            <input type="text" class="form-control" name="api_password" placeholder="Please Enter">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Default Weight</label>
                            <input type="text" class="form-control" name="default_weight" placeholder="Please Enter">
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5 class="fw-bold">Advance</h5>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6 col-lg-4">
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="auto_sync_fulfillment">Auto Sync Fulfilment Status from Leopards</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="auto_sync_fulfillment" name="auto_sync_fulfillment" value="1">
                                </div>
                                <div class="text-muted smaller">Asaan Retail will fetch the delivery status from Leopards and update order status in Asaan Retail and third parties. <a href="#" class="text-success">Learn More</a></div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Default Note</label>
                                <textarea class="form-control" name="default_note" rows="2" placeholder="Please Enter"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="set_product_details_remarks">Set Product Details in Remarks Field (If Applicable)</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="set_product_details_remarks" name="set_product_details_remarks" value="1">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="set_product_details_label">Set Product Details on Shipping Label</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="set_product_details_label" name="set_product_details_label" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-4">
                            <div class="mb-4">
                                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between mb-1">
                                    <label class="form-check-label fw-bold" for="allow_open_shipment">Allow Open Shipment at Doorstep?</label>
                                    <input class="form-check-input ms-0" type="checkbox" id="allow_open_shipment" name="allow_open_shipment" value="1">
                                </div>
                                <div class="text-muted smaller">By enabling this configuration you are allowing customers to open the shipment at doorstep for evaluation.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 justify-content-center mt-4 pb-3">
                        <div class="col-6 col-md-4">
                            <button type="submit" class="btn btn-success w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #00965e; border-color: #00965e;">
                                <span>Save</span>
                            </button>
                        </div>
                        <div class="col-6 col-md-4">
                            <button type="button" class="btn btn-success w-100 py-2 d-flex align-items-center justify-content-center gap-2" id="test-connection-leopards" style="background-color: #00965e; border-color: #00965e;">
                                <span>Test Connection</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
