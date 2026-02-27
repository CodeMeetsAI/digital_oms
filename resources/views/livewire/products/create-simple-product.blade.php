<div>
    <form wire:submit.prevent="store">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label required">SKU 
                            <span class="text-muted fw-normal">
                                (Autogenerate <input type="checkbox" wire:model.live="sku_autogenerate">) 
                                (Capitalize <input type="checkbox" wire:model.live="sku_capitalize">)
                            </span>
                        </label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" wire:model.live="code" placeholder="SKU-123" @if($sku_autogenerate) readonly @endif>
                        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Product Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.live="name" placeholder="Product Name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">HS Code <span class="form-help" data-bs-toggle="tooltip" data-bs-placement="top" title="Harmonized System Code">?</span></label>
                        <input type="text" class="form-control" wire:model="hs_code" placeholder="HS Code">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" wire:model="notes" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-label">Product Type</div>
                        <div>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" wire:model="product_type" value="simple">
                                <span class="form-check-label">Simple product, no variants</span>
                            </label>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" wire:model="product_type" value="variants" disabled>
                                <span class="form-check-label">Product with variants (Coming Soon)</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="mrp_exclusive_tax">
                            <span class="form-check-label">Is MRP exclusive of tax?</span>
                        </label>
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="third_schedule">
                            <span class="form-check-label">Is your product fall under 3rd Schedule Category?</span>
                        </label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sale Taxes</label>
                        <a href="#" class="text-success text-decoration-none fw-bold">
                            <!-- Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -3.485 -1.573l-1.68 1.68l3.71 3.71l1.68 -1.68a2 2 0 0 0 -0.225 -2.137z"/><path d="M16 19l3.71 -3.71"/></svg> 
                            Add Taxes
                        </a>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Purchase Taxes</label>
                        <a href="#" class="text-success text-decoration-none fw-bold">
                            <!-- Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -3.485 -1.573l-1.68 1.68l3.71 3.71l1.68 -1.68a2 2 0 0 0 -0.225 -2.137z"/><path d="M16 19l3.71 -3.71"/></svg> 
                            Add Taxes
                        </a>
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
                                                    <input type="text" class="form-control form-control-sm bg-light" readonly value="{{ $code }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small text-muted">Barcode</label>
                                                    <input type="text" class="form-control form-control-sm" wire:model="barcode" @if($barcode_autogenerate) readonly @endif>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-check">
                                                        <input class="form-check-input" type="checkbox" wire:model.live="barcode_autogenerate">
                                                        <span class="form-check-label small">Auto Generate Asaan Retail's Barcode.</span>
                                                    </label>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small text-muted">Product Name</label>
                                                    <input type="text" class="form-control form-control-sm bg-light" readonly value="{{ $name }}">
                                                </div>
                                            </td>
                                            <td style="vertical-align: top;">
                                                <div class="mb-2">
                                                    <label class="form-label small text-muted required">Cost Price</label>
                                                    <input type="number" step="0.01" class="form-control form-control-sm @error('buying_price') is-invalid @enderror" wire:model="buying_price">
                                                    @error('buying_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small text-muted required">Selling Price</label>
                                                    <input type="number" step="0.01" class="form-control form-control-sm @error('selling_price') is-invalid @enderror" wire:model="selling_price">
                                                    @error('selling_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small text-muted">Maximum Retail Price (MRP)</label>
                                                    <input type="number" step="0.01" class="form-control form-control-sm" wire:model="mrp">
                                                </div>
                                            </td>
                                            <td style="vertical-align: top;">
                                                <div class="mb-2">
                                                    <label class="form-label small text-muted">Re-order Threshold</label>
                                                    <input type="number" class="form-control form-control-sm" wire:model="quantity_alert">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small text-muted">Weight (kg)</label>
                                                    <input type="number" step="0.01" class="form-control form-control-sm" wire:model="weight">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small text-muted">Quantity Sync</label>
                                                    <label class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" wire:model="quantity_sync">
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-body text-center p-2 border-dashed">
                                <div class="mb-2 text-muted font-weight-bold">Picture</div>
                                @if ($product_image)
                                    <div class="mb-2">
                                        <img src="{{ $product_image->temporaryUrl() }}" class="img-fluid rounded" style="max-height: 100px;">
                                    </div>
                                @else
                                    <div class="mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-camera text-muted" width="48" height="48" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                            <path d="M9 13a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        </svg>
                                    </div>
                                    <div class="text-muted small">NO IMAGE AVAILABLE</div>
                                @endif
                                <input type="file" wire:model="product_image" class="form-control form-control-sm mt-2">
                                @error('product_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($errors->has('form'))
                <div class="alert alert-danger mt-3">{{ $errors->first('form') }}</div>
            @endif
        </div>
        <div class="modal-footer">
            @if($isModal)
            <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
            @endif
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
