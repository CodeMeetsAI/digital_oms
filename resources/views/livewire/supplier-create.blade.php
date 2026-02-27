<div>
    <form wire:submit.prevent="store">
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">General Info</h4>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label required">Supplier Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="Supplier Name">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" class="form-control @error('shopname') is-invalid @enderror" wire:model="shopname" placeholder="Supplier Name">
                @error('shopname') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">CNIC</label>
                <input type="text" class="form-control @error('cnic') is-invalid @enderror" wire:model="cnic" placeholder="xxxxx-xxxxxxx-x">
                @error('cnic') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">NTN/Tax ID</label>
                <input type="text" class="form-control @error('ntn') is-invalid @enderror" wire:model="ntn" placeholder="NTN/Tax Number">
                @error('ntn') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Website</label>
                <input type="text" class="form-control @error('website') is-invalid @enderror" wire:model="website" placeholder="Website Url">
                @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Category</label>
                <div class="input-group">
                    <select class="form-select supplier-category-select @error('supplier_category_id') is-invalid @enderror" wire:model="supplier_category_id">
                        <option value="">Default</option>
                        @foreach($supplierCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modal-supplier-category">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    </button>
                </div>
                @error('supplier_category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Opening Balance</label>
                <input type="number" class="form-control @error('opening_balance') is-invalid @enderror" wire:model="opening_balance" placeholder="0">
                @error('opening_balance') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Type</label>
                <select class="form-select @error('type') is-invalid @enderror" wire:model="type">
                    <option value="distributor">Distributor</option>
                    <option value="wholesaler">Wholesaler</option>
                    <option value="producer">Producer</option>
                </select>
                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 mt-3">
                <h4 class="mb-3">Address</h4>
            </div>
            <div class="col-md-12 mb-3">
                <textarea class="form-control @error('address') is-invalid @enderror" wire:model="address" rows="3" placeholder="Address"></textarea>
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 mt-3">
                <h4 class="mb-3">Contact Details</h4>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" wire:model="phone" placeholder="+92 301 2345678">
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" placeholder="Supplier Email">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 mt-3">
                <h4 class="mb-3">Bank Details</h4>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Account Title</label>
                <input type="text" class="form-control @error('account_holder') is-invalid @enderror" wire:model="account_holder" placeholder="Account Title">
                @error('account_holder') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Account Number</label>
                <input type="text" class="form-control @error('account_number') is-invalid @enderror" wire:model="account_number" placeholder="Account Number">
                @error('account_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Bank Name</label>
                <input type="text" class="form-control @error('bank_name') is-invalid @enderror" wire:model="bank_name" placeholder="Bank Name">
                @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Bank Branch</label>
                <input type="text" class="form-control @error('bank_branch') is-invalid @enderror" wire:model="bank_branch" placeholder="Bank Branch">
                @error('bank_branch') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">IBAN</label>
                <input type="text" class="form-control @error('iban') is-invalid @enderror" wire:model="iban" placeholder="IBAN">
                @error('iban') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Swift/BIC Code</label>
                <input type="text" class="form-control @error('swift') is-invalid @enderror" wire:model="swift" placeholder="Swift/BIC Code">
                @error('swift') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Bank Address</label>
                <input type="text" class="form-control @error('bank_address') is-invalid @enderror" wire:model="bank_address" placeholder="Bank Address">
                @error('bank_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success ms-auto">Create Supplier</button>
        </div>
    </form>

    @livewire('supplier-categories.create-supplier-category-modal')
</div>
