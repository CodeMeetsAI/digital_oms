<div>
    <form wire:submit.prevent="store">
        <div class="modal-body">
            <div class="row">
            <!-- Left: Image -->
            <div class="col-lg-3">
                <div class="mb-3">
                    <label class="form-label">Product Image</label>
                    <div class="text-center">
                        @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded mb-2" style="max-height: 200px;">
                        @else
                        <div class="border rounded d-flex align-items-center justify-content-center bg-light text-muted" style="height: 200px; width: 100%;">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-camera" width="48" height="48" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                    <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                </svg>
                                <br>NO IMAGE AVAILABLE
                            </div>
                        </div>
                        @endif
                        <input type="file" class="form-control mt-2" wire:model="image" accept="image/*">
                        @error('image') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Right: Fields -->
            <div class="col-lg-9">
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <!-- Selling Price -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Selling Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('selling_price') is-invalid @enderror" wire:model="selling_price">
                        @error('selling_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <!-- SKU -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">SKU (Autogenerate <input type="checkbox" wire:model.live="sku_autogenerate">) (Capitalize <input type="checkbox" wire:model.live="sku_capitalize">) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('sku') is-invalid @enderror" wire:model="sku" @if($sku_autogenerate) readonly @endif placeholder="SKU-123">
                        @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <!-- Total Cost -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Total Cost</label>
                        <input type="text" class="form-control bg-light" readonly wire:model="total_cost">
                    </div>
                    <!-- Quantity Sync -->
                    <div class="col-md-12 mb-3">
                        <label class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="quantity_sync">
                            <span class="form-check-label">Quantity Sync</span>
                        </label>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="mb-3 position-relative">
                    <table class="table table-bordered table-vcenter">
                        <thead>
                            <tr>
                                <th>Sku</th>
                                <th>Name</th>
                                <th>Cost Price</th>
                                <th>Selling Price</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selectedProducts as $index => $item)
                            <tr wire:key="product-{{ $index }}">
                                <td>{{ $item['code'] }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ number_format($item['buying_price'] / 100, 2) }}</td>
                                <td>{{ number_format($item['selling_price'] / 100, 2) }}</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" style="width: 80px"
                                        wire:model.live="selectedProducts.{{ $index }}.quantity"
                                        wire:change="calculateTotalCost">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-icon btn-danger btn-sm" wire:click="removeProduct({{ $index }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" class="p-0 position-relative">
                                    <input type="text" class="form-control border-0" placeholder="Type to Search Product" wire:model.live="search">
                                    @if(strlen($search) >= 2 && count($searchResults) > 0)
                                    <div class="list-group w-100 mt-1">
                                        @foreach($searchResults as $result)
                                        <a href="#" class="list-group-item list-group-item-action" wire:click.prevent="addProduct({{ $result->id }})" wire:key="result-{{ $result->id }}">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar avatar-sm me-2" style="background-image: url('{{ $result->product_image ? asset('storage/products/'.$result->product_image) : asset('assets/img/products/default.webp') }}')"></span>
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium">{{ $result->name }}</div>
                                                    <div class="text-muted small">SKU: {{ $result->code }} | Stock: {{ $result->quantity }}</div>
                                                </div>
                                                <div class="text-end">
                                                    <div class="font-weight-bold">{{ number_format($result->selling_price / 100, 2) }}</div>
                                                </div>
                                            </div>
                                        </a>
                                        @endforeach
                                    </div>
                                    @elseif(strlen($search) >= 2)
                                    <div class="list-group w-100 mt-1">
                                        <div class="list-group-item">No products found</div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @error('selectedProducts') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="4" wire:model="description"></textarea>
                </div>

            </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
</div>