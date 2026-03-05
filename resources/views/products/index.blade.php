@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header d-print-none mb-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title font-weight-bold text-dark">
                        Products
                    </h2>
                </div>
                <!-- Page Title Actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-icon btn-outline-secondary" aria-label="Search" id="product-search-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                <path d="M21 21l-6 -6" />
                            </svg>
                        </a>
                        <a href="{{ route('products.export.store') }}" class="btn btn-icon btn-outline-secondary" aria-label="Export">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                <path d="M7 9l5 -5l5 5" />
                                <path d="M12 4l0 12" />
                            </svg>
                        </a>
                        <a href="#" class="btn btn-success d-none d-sm-inline-block fw-bold" data-bs-toggle="modal" data-bs-target="#modal-create-product">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            CREATE PRODUCT
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- Products page table / header me ek button -->

        
<!-- <div class="mb-4">
    <form action="{{ route('products.sync') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Sync Products</button>
    </form>
</div> -->
<!-- Sync Products Button --> <!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success mb-2">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger mb-2">
        {{ session('error') }}
    </div>
@endif

<!-- Sync Products Button -->
<form action="{{ route('products.sync') }}" method="POST" style="margin-bottom: 20px;">
    @csrf
    <button type="submit" class="btn btn-primary">
        Sync Products
    </button>
</form>

        <div id="product-search-bar" class="d-none mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <select class="form-select w-auto" id="product-search-field">
                    <option value="code" selected>SKU</option>
                    <option value="name">Name</option>
                    <option value="barcode">Barcode</option>
                    <option value="external_mapping_id">External Mapping ID</option>
                </select>
                <div class="input-icon flex-grow-1">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                            <path d="M21 21l-6 -6" />
                        </svg>
                    </span>
                    <input type="text" class="form-control" id="product-search-input" placeholder="Search by SKU">
                </div>
                <button type="button" class="btn btn-outline-secondary" id="product-search-cancel">Cancel</button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row row-cards mb-4">
            <div class="col-md-2">
                <div class="card border-0" style="background-color: #e6f7f1;">
                    <div class="card-body p-4">
                        <div class="text-uppercase text-muted fw-bold mb-2">TOTAL SELLABLE</div>
                        <div class="h1 mb-0 fw-bold">{{ $totalSellable }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0" style="background-color: #e6f7f1;">
                    <div class="card-body p-4">
                        <div class="text-uppercase text-muted fw-bold mb-2">TOTAL WORTH (SALES)</div>
                        <div class="h1 mb-0 fw-bold">{{ format_currency($totalWorthSales) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-0" style="background-color: #e6f7f1;">
                    <div class="card-body p-4">
                        <div class="text-uppercase text-muted fw-bold mb-2">TOTAL WORTH (COST)</div>
                        <div class="h1 mb-0 fw-bold">{{ format_currency($totalWorthCost) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <x-alert />

        @livewire('tables.product-table')
    </div>
</div>

<div class="modal modal-blur fade" id="modal-create-product" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Product Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <a href="#" class="card card-link border-2 border-dark text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#modal-simple-product">
                            <div class="card-body">
                                <h3 class="card-title fw-bold">Simple Inventory</h3>
                                <p class="text-muted mb-0">Products that you buy and/or sell and that you track quantities of.</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="#" class="card card-link border-2 text-decoration-none text-dark" style="border-color: #2fb344;" data-bs-toggle="modal" data-bs-target="#modal-bundle">
                            <div class="card-body">
                                <h3 class="card-title fw-bold">Bundle</h3>
                                <p class="text-muted mb-0">A collection of products and/or services that you sell together. For example, a gift basket of fruits, vegetables and cheese.</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="#" class="card card-link border-2 border-dark text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#modal-service-product">
                            <div class="card-body">
                                <h3 class="card-title fw-bold">Service</h3>
                                <p class="text-muted mb-0">Services that you provide to customers. For example, landscaping or tax preparation services.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-simple-product" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Create Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="simple-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div id="simple-error" class="alert alert-danger d-none"></div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label required">SKU <span class="text-muted fw-normal">(Autogenerate <input type="checkbox" name="sku_autogenerate" id="sku_autogenerate">) (Capitalize <input type="checkbox" name="sku_capitalize">)</span></label>
                                <input type="text" class="form-control" name="code" id="sku_input" placeholder="SKU-123">
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Product Name</label>
                                <input type="text" class="form-control" name="name" id="name_input" placeholder="Product Name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Category</label>
                                <div class="input-group">
                                    <select class="form-select category-select" name="category_id">
                                        <option value="" selected disabled>Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modal-category" aria-label="Add Category">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">HS Code <span class="form-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Harmonized System Code">?</span></label>
                                <input type="text" class="form-control" name="hs_code" placeholder="HS Code">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="notes" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Product Type</div>
                                <div>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" name="product_type" value="simple" checked>
                                        <span class="form-check-label">Simple product, no variants</span>
                                    </label>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" name="product_type" value="variants">
                                        <span class="form-check-label">Product with variants</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" name="mrp_exclusive_tax">
                                    <span class="form-check-label">Is MRP exclusive of tax?</span>
                                </label>
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" name="third_schedule">
                                    <span class="form-check-label">Is your product fall under 3rd Schedule Category? <span class="form-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Help text">?</span></span>
                                </label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sale Taxes</label>
                                <a href="#" class="text-success text-decoration-none fw-bold"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -3.485 -1.573l-1.68 1.68l3.71 3.71l1.68 -1.68a2 2 0 0 0 -0.225 -2.137z" />
                                        <path d="M16 19l3.71 -3.71" />
                                    </svg> Add Taxes</a>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Purchase Taxes</label>
                                <a href="#" class="text-success text-decoration-none fw-bold"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -3.485 -1.573l-1.68 1.68l3.71 3.71l1.68 -1.68a2 2 0 0 0 -0.225 -2.137z" />
                                        <path d="M16 19l3.71 -3.71" />
                                    </svg> Add Taxes</a>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter card-table">
                                            <thead>
                                                <tr>
                                                    <th>Basic Info</th>
                                                    <th>Prices <span class="text-danger">*</span></th>
                                                    <th>More Info</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="vertical-align: top;">
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">SKU</label>
                                                            <input type="text" class="form-control form-control-sm bg-light" readonly placeholder="SKU-123" id="sku_display">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">Barcode</label>
                                                            <input type="text" class="form-control form-control-sm" name="barcode" id="barcode_input">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="barcode_autogenerate">
                                                                <span class="form-check-label small">Auto Generate Asaan Retail's Barcode.</span>
                                                            </label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">Product Name</label>
                                                            <input type="text" class="form-control form-control-sm bg-light" readonly placeholder="Product Name" id="name_display">
                                                        </div>
                                                    </td>
                                                    <td style="vertical-align: top;">
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted required">Cost Price</label>
                                                            <input type="number" class="form-control form-control-sm" name="buying_price" value="0">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted required">Selling Price</label>
                                                            <input type="number" class="form-control form-control-sm" name="selling_price" value="0">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">Maximum Retail Price (MRP)</label>
                                                            <input type="number" class="form-control form-control-sm" name="mrp" placeholder="Maximum Retail Price">
                                                        </div>
                                                    </td>
                                                    <td style="vertical-align: top;">
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">Re-order Threshold</label>
                                                            <input type="number" class="form-control form-control-sm" name="quantity_alert" value="0">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">Weight (kg)</label>
                                                            <input type="number" class="form-control form-control-sm" name="weight" value="0">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">Quantity Sync</label>
                                                            <label class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" name="quantity_sync" checked>
                                                            </label>
                                                        </div>

                                                        <input type="hidden" name="quantity" value="0">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card card-body text-center p-2 border-dashed">
                                        <div class="mb-2 text-muted font-weight-bold">Picture</div>
                                        <div class="mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-camera text-muted" width="48" height="48" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                                <path d="M9 13a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                            </svg>
                                        </div>
                                        <div class="text-muted small">NO IMAGE AVAILABLE</div>
                                        <input type="file" name="product_image" class="form-control form-control-sm mt-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100 fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                            <path d="M11 11v-4a3 3 0 1 1 6 0v4" />
                        </svg>
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-service-product" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Create Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="service-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_type" value="service">
                <div class="modal-body">
                    <div id="service-error" class="alert alert-danger d-none"></div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label required">SKU <span class="text-muted fw-normal">(Autogenerate <input type="checkbox" name="sku_autogenerate_service" id="sku_autogenerate_service">)</span></label>
                                <input type="text" class="form-control" name="code" id="sku_input_service" placeholder="SVC-123">
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Service Name</label>
                                <input type="text" class="form-control" name="name" id="name_input_service" placeholder="Service Name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Service Category</label>
                                <div class="input-group">
                                    <select class="form-select category-select" name="category_id">
                                        <option value="" selected disabled>Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modal-category" aria-label="Add Category">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">HS Code <span class="form-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Harmonized System Code">?</span></label>
                                <input type="text" class="form-control" name="hs_code" placeholder="HS Code">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="notes" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" name="mrp_exclusive_tax">
                                    <span class="form-check-label">Is MRP exclusive of tax?</span>
                                </label>
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" name="third_schedule">
                                    <span class="form-check-label">Is your product fall under 3rd Schedule Category? <span class="form-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Help text">?</span></span>
                                </label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sale Taxes</label>
                                <a href="#" class="text-success text-decoration-none fw-bold"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -3.485 -1.573l-1.68 1.68l3.71 3.71l1.68 -1.68a2 2 0 0 0 -0.225 -2.137z" />
                                        <path d="M16 19l3.71 -3.71" />
                                    </svg> Add Taxes</a>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Purchase Taxes</label>
                                <a href="#" class="text-success text-decoration-none fw-bold"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -3.485 -1.573l-1.68 1.68l3.71 3.71l1.68 -1.68a2 2 0 0 0 -0.225 -2.137z" />
                                        <path d="M16 19l3.71 -3.71" />
                                    </svg> Add Taxes</a>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter card-table">
                                            <thead>
                                                <tr>
                                                    <th>Basic Info</th>
                                                    <th>Prices <span class="text-danger">*</span></th>
                                                    <th>More Info</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="vertical-align: top;">
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">SKU</label>
                                                            <input type="text" class="form-control form-control-sm bg-light" readonly placeholder="SVC-123" id="sku_display_service">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">Barcode</label>
                                                            <input type="text" class="form-control form-control-sm" name="barcode" id="barcode_input_service">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="barcode_autogenerate_service">
                                                                <span class="form-check-label small">Auto Generate Asaan Retail's Barcode.</span>
                                                            </label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">Service Name</label>
                                                            <input type="text" class="form-control form-control-sm bg-light" readonly placeholder="Service Name" id="name_display_service">
                                                        </div>
                                                    </td>
                                                    <td style="vertical-align: top;">
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted required">Cost Price</label>
                                                            <input type="number" class="form-control form-control-sm" name="buying_price" value="0">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted required">Selling Price</label>
                                                            <input type="number" class="form-control form-control-sm" name="selling_price" value="0">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">Maximum Retail Price (MRP)</label>
                                                            <input type="number" class="form-control form-control-sm" name="mrp" placeholder="Maximum Retail Price">
                                                        </div>
                                                    </td>
                                                    <td style="vertical-align: top;">
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">Re-order Threshold</label>
                                                            <input type="number" class="form-control form-control-sm" name="quantity_alert" value="0">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="form-label small text-muted">Weight (kg)</label>
                                                            <input type="number" class="form-control form-control-sm" name="weight" value="0">
                                                        </div>
                                                        <!-- Hidden Unit ID and quantity -->
                                                        <input type="hidden" name="unit_id" value="{{ $units->first()->id ?? '' }}">
                                                        <input type="hidden" name="quantity" value="0">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card card-body text-center p-2 border-dashed">
                                        <div class="mb-2 text-muted font-weight-bold">Picture</div>
                                        <div class="mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-camera text-muted" width="48" height="48" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                                <path d="M9 13a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                            </svg>
                                        </div>
                                        <div class="text-muted small">NO IMAGE AVAILABLE</div>
                                        <input type="file" name="product_image" class="form-control form-control-sm mt-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100 fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                            <path d="M11 11v-4a3 3 0 1 1 6 0v4" />
                        </svg>
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-bundle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">New Bundle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bundle-form" action="{{ route('products.bundle.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div id="bundle-error" class="alert alert-danger d-none"></div>
                    <input type="hidden" name="selected_products" id="bundle-selected-products">
                    <input type="hidden" name="category_id" value="">
                    <input type="hidden" name="unit_id" value="">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">SKU <span class="text-muted fw-normal">(Autogenerate <input type="checkbox" name="sku_autogenerate" id="sku_autogenerate_bundle">) (Capitalize <input type="checkbox" name="sku_capitalize" id="sku_capitalize_bundle">)</span></label>
                                        <input type="text" class="form-control" name="sku" id="sku_input_bundle" placeholder="BND-123">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required">Bundle Name</label>
                                        <input type="text" class="form-control" name="name" id="bundle_name" placeholder="Bundle Name">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required">Selling Price</label>
                                        <input type="number" class="form-control" name="selling_price" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="description" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" name="quantity_sync" checked>
                                            <span class="form-check-label">Sync bundle quantity with components</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Search Products</label>
                                <input type="text" class="form-control" id="bundle-search" placeholder="Search by name or code" data-search-url="{{ route('products.search') }}">
                                <div id="bundle-search-results" class="list-group mt-2"></div>
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table table-sm table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Code</th>
                                            <th>Cost</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="bundle-selected-table"></tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-4 ms-auto">
                                    <label class="form-label">Total Cost</label>
                                    <input type="text" class="form-control" id="bundle-total-cost" readonly value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card card-body text-center p-2 border-dashed">
                                <div class="mb-2 text-muted font-weight-bold">Picture</div>
                                <div class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-camera text-muted" width="48" height="48" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                        <path d="M9 13a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    </svg>
                                </div>
                                <div class="text-muted small">NO IMAGE AVAILABLE</div>
                                <input type="file" name="product_image" class="form-control form-control-sm mt-2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100 fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                            <path d="M11 11v-4a3 3 0 1 1 6 0v4" />
                        </svg>
                        Create Bundle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-category" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1060;" data-store-url="{{ route('categories.store') }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Product Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="category-error" class="alert alert-danger d-none"></div>
                <label class="form-label required">Category Name</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="category-name" placeholder="Enter category name">
                    <button type="button" class="btn btn-success" id="category-save">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

 @endsection

  @push('page-scripts')
   <script>
       document.addEventListener('DOMContentLoaded', function() {
        const searchToggleButton = document.getElementById('product-search-toggle');
        const searchBar = document.getElementById('product-search-bar');
        const searchInputField = document.getElementById('product-search-input');
        const searchCancelButton = document.getElementById('product-search-cancel');
        const searchFieldSelect = document.getElementById('product-search-field');

        const emitProductSearch = (value) => {
            if (window.Livewire && typeof window.Livewire.emit === 'function') {
                window.Livewire.emit('productSearchUpdated', value);
            }
        };

        const emitProductSearchField = (value) => {
            if (window.Livewire && typeof window.Livewire.emit === 'function') {
                window.Livewire.emit('productSearchFieldUpdated', value);
            }
        };

        const updateSearchPlaceholder = (field) => {
            if (!searchInputField) return;
            if (field === 'name') {
                searchInputField.placeholder = 'Search by Name';
            } else if (field === 'barcode') {
                searchInputField.placeholder = 'Search by Barcode';
            } else if (field === 'external_mapping_id') {
                searchInputField.placeholder = 'Search by External Mapping ID';
            } else {
                searchInputField.placeholder = 'Search by SKU';
            }
        };

        if (searchToggleButton && searchBar && searchInputField) {
            searchToggleButton.addEventListener('click', function(event) {
                event.preventDefault();
                searchBar.classList.remove('d-none');
                searchInputField.focus();
            });

            searchInputField.addEventListener('input', function() {
                emitProductSearch(this.value.trim());
            });
        }

        if (searchFieldSelect) {
            updateSearchPlaceholder(searchFieldSelect.value);
            searchFieldSelect.addEventListener('change', function() {
                updateSearchPlaceholder(this.value);
                emitProductSearchField(this.value);
                if (searchInputField) {
                    emitProductSearch(searchInputField.value.trim());
                }
            });
        }

        if (searchCancelButton && searchBar && searchInputField) {
            searchCancelButton.addEventListener('click', function() {
                searchInputField.value = '';
                emitProductSearch('');
                searchBar.classList.add('d-none');
            });
        }

          // SKU Auto-generation
        const skuInput = document.getElementById('sku_input');
        const skuDisplay = document.getElementById('sku_display');
        const skuAutoCheckbox = document.getElementById('sku_autogenerate');

        if (skuAutoCheckbox) {
            skuAutoCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    const randomSku = 'SKU-' + Math.floor(Math.random() * 100000000);
                    skuInput.value = randomSku;
                    skuInput.readOnly = true;
                    if (skuDisplay) skuDisplay.value = randomSku;
                } else {
                    skuInput.value = '';
                    skuInput.readOnly = false;
                    if (skuDisplay) skuDisplay.value = '';
                }
            });
        }

        if (skuInput) {
            skuInput.addEventListener('input', function() {
                if (skuDisplay) skuDisplay.value = this.value;
            });
        }

        // Barcode Auto-generation
        const barcodeInput = document.getElementById('barcode_input');
        const barcodeAutoCheckbox = document.getElementById('barcode_autogenerate');

        if (barcodeAutoCheckbox) {
            barcodeAutoCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    const randomBarcode = Math.floor(100000000000 + Math.random() * 900000000000); // 12 digit random
                    barcodeInput.value = randomBarcode;
                    barcodeInput.readOnly = true;
                } else {
                    barcodeInput.value = '';
                    barcodeInput.readOnly = false;
                }
            });
        }

        // Product Name Mirroring
        const nameInput = document.getElementById('name_input');
        const nameDisplay = document.getElementById('name_display');

        if (nameInput) {
            nameInput.addEventListener('input', function() {
                if (nameDisplay) nameDisplay.value = this.value;
            });
        }

        const skuInputService = document.getElementById('sku_input_service');
        const skuDisplayService = document.getElementById('sku_display_service');
        const skuAutoCheckboxService = document.getElementById('sku_autogenerate_service');

        if (skuAutoCheckboxService && skuInputService) {
            skuAutoCheckboxService.addEventListener('change', function() {
                if (this.checked) {
                    const randomSku = 'SVC-' + Math.floor(Math.random() * 100000000);
                    skuInputService.value = randomSku;
                    skuInputService.readOnly = true;
                    if (skuDisplayService) skuDisplayService.value = randomSku;
                } else {
                    skuInputService.value = '';
                    skuInputService.readOnly = false;
                    if (skuDisplayService) skuDisplayService.value = '';
                }
            });
        }

        if (skuInputService) {
            skuInputService.addEventListener('input', function() {
                if (skuDisplayService) skuDisplayService.value = this.value;
            });
        }

        const barcodeInputService = document.getElementById('barcode_input_service');
        const barcodeAutoCheckboxService = document.getElementById('barcode_autogenerate_service');

        if (barcodeAutoCheckboxService && barcodeInputService) {
            barcodeAutoCheckboxService.addEventListener('change', function() {
                if (this.checked) {
                    const randomBarcode = Math.floor(100000000000 + Math.random() * 900000000000);
                    barcodeInputService.value = randomBarcode;
                    barcodeInputService.readOnly = true;
                } else {
                    barcodeInputService.value = '';
                    barcodeInputService.readOnly = false;
                }
            });
        }

        const nameInputService = document.getElementById('name_input_service');
        const nameDisplayService = document.getElementById('name_display_service');

        if (nameInputService) {
            nameInputService.addEventListener('input', function() {
                if (nameDisplayService) nameDisplayService.value = this.value;
            });
        }

        const skuInputBundle = document.getElementById('sku_input_bundle');
        const skuAutoCheckboxBundle = document.getElementById('sku_autogenerate_bundle');
        const skuCapitalizeBundle = document.getElementById('sku_capitalize_bundle');

        if (skuAutoCheckboxBundle && skuInputBundle) {
            skuAutoCheckboxBundle.addEventListener('change', function() {
                if (this.checked) {
                    const randomSku = 'BND-' + Math.floor(Math.random() * 100000000);
                    skuInputBundle.value = randomSku;
                    skuInputBundle.readOnly = true;
                } else {
                    skuInputBundle.value = '';
                    skuInputBundle.readOnly = false;
                }
            });
        }

        if (skuCapitalizeBundle && skuInputBundle) {
            skuCapitalizeBundle.addEventListener('change', function() {
                if (this.checked) {
                    skuInputBundle.value = skuInputBundle.value.toUpperCase();
                }
            });
        }

        if (skuInputBundle) {
            skuInputBundle.addEventListener('input', function() {
                if (skuCapitalizeBundle && skuCapitalizeBundle.checked) {
                    this.value = this.value.toUpperCase();
                }
            });
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const bundleForm = document.getElementById('bundle-form');
        const bundleError = document.getElementById('bundle-error');
        const bundleSearchInput = document.getElementById('bundle-search');
        const bundleSearchResults = document.getElementById('bundle-search-results');
        const bundleSelectedTable = document.getElementById('bundle-selected-table');
        const bundleSelectedInput = document.getElementById('bundle-selected-products');
        const bundleTotalCostInput = document.getElementById('bundle-total-cost');
        const simpleForm = document.getElementById('simple-form');
        const simpleError = document.getElementById('simple-error');
        const serviceForm = document.getElementById('service-form');
        const serviceError = document.getElementById('service-error');
        const refreshDelay = 1200;
        const categoryModalEl = document.getElementById('modal-category');
        const categoryError = document.getElementById('category-error');
        const categoryNameInput = document.getElementById('category-name');
        const categorySaveButton = document.getElementById('category-save');

        let bundleSelectedProducts = [];
        let searchTimeout;

        const clearError = (element) => {
            if (!element) return;
            element.textContent = '';
            element.classList.add('d-none');
        };

        const showError = (element, message) => {
            if (!element) return;
            element.textContent = message;
            element.classList.remove('d-none');
        };

        const extractErrorMessage = (data) => {
            if (data && data.message) return data.message;
            if (data && data.errors) {
                return Object.values(data.errors).flat().join(' ');
            }
            return 'Something went wrong.';
        };

        const formatPrice = (value) => {
            const numberValue = Number(value) || 0;
            return (numberValue / 100).toFixed(2);
        };

        const addCategoryToSelects = (category) => {
            const selects = document.querySelectorAll('.category-select');
            selects.forEach(select => {
                const option = new Option(category.name, category.id);
                select.add(option, undefined);
                select.value = category.id;
            });
        };

        if (categoryModalEl) {
            categoryModalEl.addEventListener('show.bs.modal', function() {
                const openModal = document.querySelector('.modal.show');
                if (openModal && openModal.id && openModal.id !== categoryModalEl.id) {
                    categoryModalEl.dataset.prevModalId = openModal.id;
                } else {
                    categoryModalEl.dataset.prevModalId = '';
                }
            });

            categoryModalEl.addEventListener('hidden.bs.modal', function() {
                const prevModalId = categoryModalEl.dataset.prevModalId;
                if (!prevModalId) return;
                const prevModalEl = document.getElementById(prevModalId);
                if (!prevModalEl) return;
                const prevModal = bootstrap.Modal.getOrCreateInstance(prevModalEl);
                prevModal.show();
                categoryModalEl.dataset.prevModalId = '';
            });
        }

        if (categorySaveButton && categoryNameInput && categoryModalEl) {
            categorySaveButton.addEventListener('click', async function() {
                clearError(categoryError);
                const name = categoryNameInput.value.trim();
                if (!name) {
                    showError(categoryError, 'Category name is required.');
                    return;
                }

                const storeUrl = categoryModalEl.dataset.storeUrl;
                const response = await fetch(storeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: JSON.stringify({ name })
                });

                if (!response.ok) {
                    const data = await response.json().catch(() => ({}));
                    showError(categoryError, extractErrorMessage(data));
                    return;
                }

                const data = await response.json().catch(() => ({}));
                if (data && data.category) {
                    addCategoryToSelects(data.category);
                }
                if (typeof notyf !== 'undefined') {
                    notyf.success(data.message || 'Category created successfully.');
                }
                categoryNameInput.value = '';
                const modal = bootstrap.Modal.getInstance(categoryModalEl);
                if (modal) modal.hide();
            });
        }

        const renderBundleTable = () => {
            if (!bundleSelectedTable) return;
            bundleSelectedTable.innerHTML = '';

            let totalCost = 0;

            bundleSelectedProducts.forEach((item, index) => {
                const subtotal = (Number(item.buying_price) || 0) * (Number(item.quantity) || 0);
                totalCost += subtotal;

                const row = document.createElement('tr');

                const nameCell = document.createElement('td');
                nameCell.textContent = item.name;

                const codeCell = document.createElement('td');
                codeCell.textContent = item.code;

                const costCell = document.createElement('td');
                costCell.textContent = formatPrice(item.buying_price);

                const quantityCell = document.createElement('td');
                const quantityInput = document.createElement('input');
                quantityInput.type = 'number';
                quantityInput.min = '1';
                quantityInput.className = 'form-control form-control-sm';
                quantityInput.value = item.quantity;
                quantityInput.addEventListener('input', function() {
                    const updatedQuantity = Number(this.value) || 1;
                    bundleSelectedProducts[index].quantity = updatedQuantity < 1 ? 1 : updatedQuantity;
                    renderBundleTable();
                });
                quantityCell.appendChild(quantityInput);

                const subtotalCell = document.createElement('td');
                subtotalCell.textContent = formatPrice(subtotal);

                const removeCell = document.createElement('td');
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-sm';
                removeButton.textContent = 'Remove';
                removeButton.addEventListener('click', function() {
                    bundleSelectedProducts.splice(index, 1);
                    renderBundleTable();
                });
                removeCell.appendChild(removeButton);

                row.appendChild(nameCell);
                row.appendChild(codeCell);
                row.appendChild(costCell);
                row.appendChild(quantityCell);
                row.appendChild(subtotalCell);
                row.appendChild(removeCell);

                bundleSelectedTable.appendChild(row);
            });

            if (bundleTotalCostInput) {
                bundleTotalCostInput.value = formatPrice(totalCost);
            }
        };

        const renderSearchResults = (products) => {
            if (!bundleSearchResults) return;
            bundleSearchResults.innerHTML = '';

            products.forEach((product) => {
                const item = document.createElement('button');
                item.type = 'button';
                item.className = 'list-group-item list-group-item-action d-flex align-items-center';

                const image = document.createElement('img');
                image.src = product.product_image_url;
                image.alt = product.name;
                image.className = 'avatar avatar-sm me-2';

                const textWrapper = document.createElement('div');
                const name = document.createElement('div');
                name.className = 'fw-bold';
                name.textContent = product.name;
                const code = document.createElement('div');
                code.className = 'text-muted small';
                code.textContent = product.code;
                textWrapper.appendChild(name);
                textWrapper.appendChild(code);

                item.appendChild(image);
                item.appendChild(textWrapper);

                item.addEventListener('click', function() {
                    if (bundleSelectedProducts.find((item) => item.id === product.id)) {
                        if (typeof notyf !== 'undefined') {
                            notyf.error('Product already added.');
                        }
                        return;
                    }

                    bundleSelectedProducts.push({
                        id: product.id,
                        name: product.name,
                        code: product.code,
                        buying_price: product.buying_price,
                        quantity: 1
                    });

                    renderBundleTable();
                    if (bundleSearchInput) bundleSearchInput.value = '';
                    bundleSearchResults.innerHTML = '';
                });

                bundleSearchResults.appendChild(item);
            });
        };

        if (bundleSearchInput) {
            bundleSearchInput.addEventListener('input', function() {
                const searchTerm = this.value.trim();
                if (searchTimeout) clearTimeout(searchTimeout);
                if (searchTerm.length < 2) {
                    if (bundleSearchResults) bundleSearchResults.innerHTML = '';
                    return;
                }

                searchTimeout = setTimeout(async () => {
                    const searchUrl = this.dataset.searchUrl;
                    if (!searchUrl) return;

                    const response = await fetch(`${searchUrl}?search=${encodeURIComponent(searchTerm)}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        return;
                    }

                    const data = await response.json();
                    if (data && data.success) {
                        renderSearchResults(data.products || []);
                    }
                }, 300);
            });
        }

        if (bundleForm) {
            bundleForm.addEventListener('submit', async function(event) {
                event.preventDefault();
                clearError(bundleError);

                if (bundleSelectedProducts.length === 0) {
                    showError(bundleError, 'Please add at least one product.');
                    return;
                }

                if (bundleSelectedInput) {
                    const payload = bundleSelectedProducts.map((item) => ({
                        id: item.id,
                        quantity: item.quantity
                    }));
                    bundleSelectedInput.value = JSON.stringify(payload);
                }

                const formData = new FormData(bundleForm);

                const response = await fetch(bundleForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    const data = await response.json();
                    if (typeof notyf !== 'undefined') {
                        notyf.success('Bundle created successfully.');
                    }
                    const modalEl = document.getElementById('modal-bundle');
                    const modal = modalEl ? bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl) : null;
                    if (modal) modal.hide();
                    bundleForm.reset();
                    bundleSelectedProducts = [];
                    if (bundleSearchResults) bundleSearchResults.innerHTML = '';
                    renderBundleTable();
                    setTimeout(() => window.location.reload(), refreshDelay);
                } else {
                    const data = await response.json().catch(() => ({}));
                    showError(bundleError, extractErrorMessage(data));
                }
            });
        }

        if (simpleForm) {
            simpleForm.addEventListener('submit', async function(event) {
                event.preventDefault();
                clearError(simpleError);

                const formData = new FormData(simpleForm);

                const response = await fetch(simpleForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    await response.json().catch(() => ({}));
                    if (typeof notyf !== 'undefined') {
                        notyf.success('Product created successfully.');
                    }
                    const modalEl = document.getElementById('modal-simple-product');
                    const modal = modalEl ? bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl) : null;
                    if (modal) modal.hide();
                    simpleForm.reset();
                    setTimeout(() => window.location.reload(), refreshDelay);
                } else {
                    const data = await response.json().catch(() => ({}));
                    showError(simpleError, extractErrorMessage(data));
                }
            });
        }

        if (serviceForm) {
            serviceForm.addEventListener('submit', async function(event) {
                event.preventDefault();
                clearError(serviceError);

                const formData = new FormData(serviceForm);

                const response = await fetch(serviceForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    await response.json().catch(() => ({}));
                    if (typeof notyf !== 'undefined') {
                        notyf.success('Service created successfully.');
                    }
                    const modalEl = document.getElementById('modal-service-product');
                    const modal = modalEl ? bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl) : null;
                    if (modal) modal.hide();
                    serviceForm.reset();
                    setTimeout(() => window.location.reload(), refreshDelay);
                } else {
                    const data = await response.json().catch(() => ({}));
                    showError(serviceError, extractErrorMessage(data));
                }
            });
        }
    });
</script>
@endpush
