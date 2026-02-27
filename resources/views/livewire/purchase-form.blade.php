<div>
    <div class="modal-content">
        <form wire:submit.prevent="store">
            <div class="modal-header">
                <h5 class="modal-title">Create Purchase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label required">Supplier:</label>
                        <div class="input-group">
                            <select wire:model="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-purchase-supplier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            </button>
                        </div>
                        @error('supplier_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">PO Reference No.:</label>
                        <input type="text" wire:model="po_reference" class="form-control" placeholder="">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label required">PO Date:</label>
                        <input type="date" wire:model="date" class="form-control @error('date') is-invalid @enderror">
                        @error('date') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Due Date:</label>
                        <input type="date" wire:model="due_date" class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Discount %:</label>
                        <input type="number" step="0.01" wire:model.live.debounce.500ms="discount_percentage" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Purchase Lines:</label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-vcenter">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Purchasing Price</th>
                                    <th>Discount %</th>
                                    <th>Tax</th>
                                    <th>Sub Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="8" class="p-2">
                                        <div class="input-group">
                                            <input type="text" 
                                                   class="form-control" 
                                                   placeholder="Type to Search Product" 
                                                   wire:model.live.debounce.300ms="searchProduct"
                                            >
                                            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modal-purchase-product">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                            </button>
                                        </div>
                                        @if(!empty($searchResults))
                                            <div class="list-group position-absolute w-100" style="z-index: 1000;">
                                                @foreach($searchResults as $result)
                                                    <button type="button" 
                                                            class="list-group-item list-group-item-action"
                                                            wire:click="selectProduct({{ $result->id }})">
                                                        {{ $result->name }} ({{ $result->code }})
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @forelse($invoiceProducts as $index => $product)
                                    <tr wire:key="product-row-{{ $index }}">
                                        <td>{{ $product['sku'] }}</td>
                                        <td>{{ $product['name'] }}</td>
                                        <td>
                                            <input type="number" 
                                                   class="form-control" 
                                                   wire:model.live="invoiceProducts.{{ $index }}.quantity" 
                                                   min="1"
                                            >
                                        </td>
                                        <td>
                                            <input type="number" 
                                                   class="form-control" 
                                                   wire:model.live="invoiceProducts.{{ $index }}.unit_price" 
                                                   step="0.01"
                                            >
                                        </td>
                                        <td>
                                            <input type="number" 
                                                   class="form-control" 
                                                   wire:model.live="invoiceProducts.{{ $index }}.discount_percentage" 
                                                   step="0.01"
                                            >
                                        </td>
                                        <td>
                                            <input type="number" 
                                                   class="form-control" 
                                                   wire:model.live="invoiceProducts.{{ $index }}.tax_amount" 
                                                   step="0.01"
                                            >
                                        </td>
                                        <td>{{ Number::currency($product['sub_total'], 'EUR') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-outline-danger" wire:click="removeProduct({{ $index }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No products added</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Total Quantity</label>
                            <div class="form-control-plaintext">
                                {{ collect($invoiceProducts)->sum('quantity') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-end fw-bold">Gross Amount</td>
                                <td class="text-end">{{ Number::currency($gross_amount, 'EUR') }}</td>
                            </tr>
                            <tr>
                                <td class="text-end fw-bold">Discount</td>
                                <td class="text-end">{{ Number::currency($total_discount, 'EUR') }}</td>
                            </tr>
                            <tr>
                                <td class="text-end fw-bold">Tax</td>
                                <td class="text-end">{{ Number::currency($total_tax, 'EUR') }}</td>
                            </tr>
                            <tr>
                                <td class="text-end fw-bold">Net Amount</td>
                                <td class="text-end">{{ Number::currency($net_amount, 'EUR') }}</td>
                            </tr>
                            <tr>
                                <td class="text-end fw-bold">Paid Amount</td>
                                <td class="text-end">
                                    <input type="number" class="form-control d-inline-block w-50 text-end" wire:model="paid_amount" step="0.01">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Supplier Notes:</label>
                    <textarea class="form-control" rows="3" wire:model="supplier_notes" placeholder="Enter supplier notes"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Attachments:</label>
                    <input type="file" class="form-control" wire:model="attachments">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                    Save Bill
                </button>
            </div>
        </form>
    </div>
    
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', (event) => {
                const modalId = event.modal;
                const modalElement = document.querySelector(modalId);
                if (modalElement) {
                    const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                    modalInstance.hide();
                }
            });
        });
    </script>
</div>