@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title">
                    {{ __('Supplier - ') }} {{ $supplier->name }}
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                 <x-action.close route="{{ route('suppliers.index') }}" />
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('suppliers.update', $supplier) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    
                                    <h3 class="mb-3">General Info</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label required">Supplier Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $supplier->name) }}" required>
                                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Company Name</label>
                                                <input type="text" class="form-control @error('shopname') is-invalid @enderror" name="shopname" value="{{ old('shopname', $supplier->shopname) }}">
                                                @error('shopname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">CNIC <i class="icon ti ti-info-circle"></i></label>
                                                <input type="text" class="form-control @error('cnic') is-invalid @enderror" name="cnic" value="{{ old('cnic', $supplier->cnic) }}" placeholder="xxxxx-xxxxxxx-x">
                                                @error('cnic') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">NTN/Tax ID <i class="icon ti ti-info-circle"></i></label>
                                                <input type="text" class="form-control @error('ntn') is-invalid @enderror" name="ntn" value="{{ old('ntn', $supplier->ntn) }}">
                                                @error('ntn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Website</label>
                                                <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website', $supplier->website) }}" placeholder="Enter URL">
                                                @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $supplier->address) }}" placeholder="Address">
                                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Category</label>
                                                <div class="input-group">
                                                    <select class="form-select supplier-category-select @error('supplier_category_id') is-invalid @enderror" name="supplier_category_id">
                                                        <option value="" @selected(is_null($supplier->supplier_category_id))>Default</option>
                                                        @foreach($supplierCategories as $category)
                                                            <option value="{{ $category->id }}" @selected(old('supplier_category_id', $supplier->supplier_category_id) == $category->id)>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modal-supplier-category">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                                    </button>
                                                    @error('supplier_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-label">Supplier Status</div>
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="status" value="1" @checked(old('status', $supplier->status))>
                                                    <span class="form-check-label"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Hidden Type Field as it is not in the screenshot but required by request, defaulting to existing or first -->
                                        <input type="hidden" name="type" value="{{ $supplier->type->value }}">
                                    </div>

                                    <h3 class="mb-3 mt-4">Contact Details</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <div class="input-group">
                                                <select class="form-select" name="phone_country_code" style="max-width: 120px;">
                                                    <option value="+92" @selected(old('phone_country_code', '+92') == '+92')>+92</option>
                                                    <option value="+1" @selected(old('phone_country_code') == '+1')>+1</option>
                                                    <option value="+44" @selected(old('phone_country_code') == '+44')>+44</option>
                                                    <option value="+971" @selected(old('phone_country_code') == '+971')>+971</option>
                                                    <option value="+966" @selected(old('phone_country_code') == '+966')>+966</option>
                                                    <option value="+91" @selected(old('phone_country_code') == '+91')>+91</option>
                                                    <option value="+61" @selected(old('phone_country_code') == '+61')>+61</option>
                                                    <option value="+880" @selected(old('phone_country_code') == '+880')>+880</option>
                                                </select>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $supplier->phone) }}">
                                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email Address</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $supplier->email) }}" placeholder="Supplier Email">
                                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="mb-3 mt-4">Bank Details</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Account Title <i class="icon ti ti-info-circle"></i></label>
                                                <input type="text" class="form-control @error('account_holder') is-invalid @enderror" name="account_holder" value="{{ old('account_holder', $supplier->account_holder) }}" placeholder="Account Title">
                                                @error('account_holder') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Account Number <i class="icon ti ti-info-circle"></i></label>
                                                <input type="text" class="form-control @error('account_number') is-invalid @enderror" name="account_number" value="{{ old('account_number', $supplier->account_number) }}" placeholder="Account Number">
                                                @error('account_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Bank Name <i class="icon ti ti-info-circle"></i></label>
                                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ old('bank_name', $supplier->bank_name) }}" placeholder="Bank Name">
                                                @error('bank_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Bank Branch <i class="icon ti ti-info-circle"></i></label>
                                                <input type="text" class="form-control @error('bank_branch') is-invalid @enderror" name="bank_branch" value="{{ old('bank_branch', $supplier->bank_branch) }}" placeholder="Bank Branch">
                                                @error('bank_branch') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">IBAN <i class="icon ti ti-info-circle"></i></label>
                                                <input type="text" class="form-control @error('iban') is-invalid @enderror" name="iban" value="{{ old('iban', $supplier->iban) }}" placeholder="IBAN">
                                                @error('iban') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Swift/BIC Code <i class="icon ti ti-info-circle"></i></label>
                                                <input type="text" class="form-control @error('swift') is-invalid @enderror" name="swift" value="{{ old('swift', $supplier->swift) }}" placeholder="Swift/BIC Code">
                                                @error('swift') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Bank Address <i class="icon ti ti-info-circle"></i></label>
                                                <input type="text" class="form-control @error('bank_address') is-invalid @enderror" name="bank_address" value="{{ old('bank_address', $supplier->bank_address) }}" placeholder="Bank Address">
                                                @error('bank_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-end bg-transparent">
                                        <button type="submit" class="btn btn-success" style="background-color: #00a65a; border-color: #00a65a;">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('livewire.supplier-categories.create-supplier-category-modal')

@endsection

@pushonce('page-scripts')
<script src="{{ asset('assets/js/img-preview.js') }}"></script>
@endpushonce
