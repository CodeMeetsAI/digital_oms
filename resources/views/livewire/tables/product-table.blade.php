<div>
    <div class="card">
        <div class="card-header border-bottom-0">
            <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
                <!-- Tabs/Filters -->
                <div class="btn-group" role="group">
                    <a href="#" wire:click.prevent="setStatus('all')" class="btn {{ $status === 'all' ? 'btn-dark' : 'btn-light' }} fw-bold">All ({{ $countAll }})</a>
                    <a href="#" wire:click.prevent="setStatus('in_stock')" class="btn {{ $status === 'in_stock' ? 'btn-dark' : 'btn-light' }}">In Stock ({{ $countInStock }})</a>
                    <a href="#" wire:click.prevent="setStatus('out_of_stock')" class="btn {{ $status === 'out_of_stock' ? 'btn-dark' : 'btn-light' }}">Out of Stock ({{ $countOutOfStock }})</a>
                    <a href="#" wire:click.prevent="setStatus('low_stock')" class="btn {{ $status === 'low_stock' ? 'btn-dark' : 'btn-light' }}">Low Stock ({{ $countLowStock }})</a>
                    <a href="#" wire:click.prevent="setStatus('services')" class="btn {{ $status === 'services' ? 'btn-dark' : 'btn-light' }}">Services ({{ $countServices }})</a>
                    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Optional: Show a toast or tooltip
                // For now, we can rely on user action, or maybe change icon temporarily
            }, function(err) {
                console.error('Async: Could not copy text: ', err);
            });
        }
    </script>
    <style>
        .group-hover-copy:hover .copy-btn {
            opacity: 1 !important;
            transition: opacity 0.2s ease-in-out;
        }
    </style>
</div>

                <!-- Right Side Controls -->
                <div class="d-flex align-items-center gap-2">
                    <div class="dropdown">
                        <button type="button" class="btn btn-icon btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item {{ $status === 'all' ? 'active' : '' }}" wire:click.prevent="setStatus('all')">All ({{ $countAll }})</a>
                            <a href="#" class="dropdown-item {{ $status === 'in_stock' ? 'active' : '' }}" wire:click.prevent="setStatus('in_stock')">In Stock ({{ $countInStock }})</a>
                            <a href="#" class="dropdown-item {{ $status === 'out_of_stock' ? 'active' : '' }}" wire:click.prevent="setStatus('out_of_stock')">Out of Stock ({{ $countOutOfStock }})</a>
                            <a href="#" class="dropdown-item {{ $status === 'low_stock' ? 'active' : '' }}" wire:click.prevent="setStatus('low_stock')">Low Stock ({{ $countLowStock }})</a>
                            <a href="#" class="dropdown-item {{ $status === 'services' ? 'active' : '' }}" wire:click.prevent="setStatus('services')">Services ({{ $countServices }})</a>
                        </div>
                    </div>
                    <label class="form-check form-check-inline mb-0 d-flex align-items-center">
                        <input class="form-check-input me-2" type="checkbox">
                        <span class="form-check-label text-muted">Show more options</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle ms-1 text-muted" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                    </label>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-vcenter table-mobile-md card-table">
                <thead style="background-color: #e6f7f1;">
                    <tr>
                        <th class="w-1"><input class="form-check-input" type="checkbox"></th>
                        <th class="text-uppercase small font-weight-bold text-muted cursor-pointer" wire:click="sortBy('code')">
                            SKU 
                            @if($sortField === 'code')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-{{ $sortAsc ? 'up' : 'down' }}" width="12" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="18" y1="13" x2="12" y2="19" /><line x1="6" y1="13" x2="12" y2="19" /></svg>
                            @endif
                        </th>
                        <th class="text-uppercase small font-weight-bold text-muted cursor-pointer" wire:click="sortBy('name')">
                            NAME
                            @if($sortField === 'name')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-{{ $sortAsc ? 'up' : 'down' }}" width="12" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="18" y1="13" x2="12" y2="19" /><line x1="6" y1="13" x2="12" y2="19" /></svg>
                            @endif
                        </th>
                        <th class="text-uppercase small font-weight-bold text-muted">IMAGE</th>
                        <th class="text-uppercase small font-weight-bold text-muted">BARCODE</th>
                        <th class="text-uppercase small font-weight-bold text-muted cursor-pointer" wire:click="sortBy('buying_price')">
                            COST PRICE
                            @if($sortField === 'buying_price')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-{{ $sortAsc ? 'up' : 'down' }}" width="12" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="18" y1="13" x2="12" y2="19" /><line x1="6" y1="13" x2="12" y2="19" /></svg>
                            @endif
                        </th>
                        <th class="text-uppercase small font-weight-bold text-muted cursor-pointer" wire:click="sortBy('selling_price')">
                            SELLING PRICE
                            @if($sortField === 'selling_price')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-{{ $sortAsc ? 'up' : 'down' }}" width="12" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="18" y1="13" x2="12" y2="19" /><line x1="6" y1="13" x2="12" y2="19" /></svg>
                            @endif
                        </th>
                        <th class="text-uppercase small font-weight-bold text-muted">LOCATION</th>
                        <th class="text-uppercase small font-weight-bold text-muted cursor-pointer" wire:click="sortBy('quantity')">
                            ON HAND
                            @if($sortField === 'quantity')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-{{ $sortAsc ? 'up' : 'down' }}" width="12" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="18" y1="13" x2="12" y2="19" /><line x1="6" y1="13" x2="12" y2="19" /></svg>
                            @endif
                             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="12" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                        </th>
                        <th class="text-uppercase small font-weight-bold text-muted">
                            COMMITTED
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="12" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                        </th>
                        <th class="text-uppercase small font-weight-bold text-muted">
                            AVAILABLE QTY
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="12" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                        </th>
                        <th class="text-uppercase small font-weight-bold text-muted">
                            INBOUND QTY
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="12" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                        </th>
                        <th class="text-uppercase small font-weight-bold text-muted">
                            UNFULFILLABLE QTY
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="12" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                        </th>
                        <th class="text-uppercase small font-weight-bold text-muted">LINKED STORE</th>
                        <th class="text-uppercase small font-weight-bold text-muted">TAGS</th>
                        <th class="text-uppercase small font-weight-bold text-muted">WEIGHT</th>
                        <th class="text-uppercase small font-weight-bold text-muted">TYPE</th>
                        <th class="text-uppercase small font-weight-bold text-muted">BRAND</th>
                        <th class="text-uppercase small font-weight-bold text-muted">CATEGORY</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>{{ $product->code }}</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('{{ $product->code }}')" title="Copy SKU">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>{{ $product->name }}</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('{{ $product->name }}')" title="Copy Name">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                @if($product->product_image)
                                    <img src="{{ asset('storage/products/' . $product->product_image) }}" alt="{{ $product->name }}" class="avatar avatar-sm">
                                @else
                                    <span class="avatar avatar-sm bg-secondary-lt">NO IMG</span>
                                @endif
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>{{ optional($product->simpleInventory)->barcode ?? $product->code }}</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('{{ optional($product->simpleInventory)->barcode ?? $product->code }}')" title="Copy Barcode">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>{{ format_currency($product->buying_price) }}</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('{{ format_currency($product->buying_price) }}')" title="Copy Cost Price">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>{{ format_currency($product->selling_price) }}</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('{{ format_currency($product->selling_price) }}')" title="Copy Selling Price">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>-</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('-')" title="Copy Location">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>{{ $product->quantity }}</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('{{ $product->quantity }}')" title="Copy On Hand">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>0</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('0')" title="Copy Committed">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>{{ $product->quantity }}</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('{{ $product->quantity }}')" title="Copy Available">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>0</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('0')" title="Copy Inbound">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>0</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('0')" title="Copy Unfulfillable">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>-</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('-')" title="Copy Linked Store">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>-</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('-')" title="Copy Tags">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>{{ optional($product->simpleInventory)->weight ?? '-' }}</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('{{ optional($product->simpleInventory)->weight ?? '-' }}')" title="Copy Weight">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>{{ optional($product->simpleInventory)->product_type ?? ($product->bundle ? 'Bundle' : '-') }}</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('{{ optional($product->simpleInventory)->product_type ?? ($product->bundle) }}')" title="Copy Type">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>-</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('-')" title="Copy Brand">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="group-hover-copy position-relative d-flex align-items-center justify-content-between">
                                    <span>{{ $product->category->name ?? '-' }}</span>
                                    <button class="btn btn-icon btn-sm btn-ghost-secondary copy-btn opacity-0" onclick="copyToClipboard('{{ $product->category->name ?? '-' }}')" title="Copy Category">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="19" class="text-center py-5">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="48" height="48" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 9l1 0" /><path d="M9 13l6 0" /><path d="M9 17l6 0" /></svg>
                                    </div>
                                    <p class="empty-title">No Products yet</p>
                                    <p class="empty-subtitle text-muted">
                                        Products will be displayed here when available
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <span class="text-muted small me-2">Show</span>
                <select wire:model.live="perPage" class="form-select form-select-sm w-auto">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-muted small ms-2">Entries</span>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                {{ $products->links() }}
            </div>

            <div class="d-flex align-items-center">
                 <span class="text-muted small ms-2">Page {{ $products->currentPage() }} of {{ $products->lastPage() }} ({{ $products->total() }} total entries)</span>
            </div>
        </div>
    </div>
</div>
