@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <!-- Alert -->
        <x-alert />

        <!-- Page Header -->
        <div class="page-header d-print-none mb-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="d-flex align-items-center">
                        <span class="text-success me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                            </svg>
                        </span>
                        <h2 class="page-title font-weight-bold text-dark">
                            Chart Of Accounts
                        </h2>
                    </div>
                    <div class="text-muted mt-1">
                        Accounts currently in use for recording transactions and managing your finances.
                    </div>
                </div>
                <!-- Page Title Actions -->
                <div class="col-auto ms-auto d-print-none">
                    <!-- Actions moved to Livewire component -->
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal modal-blur fade" id="modal-edit-account" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Chart of Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="edit-account-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <!-- Basic Column -->
                                <div class="col-lg-4 border-end">
                                    <h4 class="mb-3 text-uppercase text-muted" style="border-bottom: 2px solid #ddd; padding-bottom: 5px;">Basic</h4>
                                    
                                    <div class="mb-3">
                                        <label class="form-label required">Name</label>
                                        <input type="text" name="name" id="edit-name" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <input type="text" name="description" id="edit-description" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Type</label>
                                        <select name="type" id="edit-type" class="form-select" required>
                                            <option value="Asset">Assets</option>
                                            <option value="Liability">Liability</option>
                                            <option value="Equity">Equity</option>
                                            <option value="Revenue">Revenue</option>
                                            <option value="Expense">Expense</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" name="status" id="edit-status" value="1">
                                            <span class="form-check-label">Active</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Opening Balance Column -->
                                <div class="col-lg-4 border-end">
                                    <h4 class="mb-3 text-uppercase text-muted" style="border-bottom: 2px solid #ddd; padding-bottom: 5px;">Opening Balance</h4>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Payment Mode</label>
                                        <select name="payment_mode" id="edit-payment_mode" class="form-select">
                                            <option value="Cheque">Cheque</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Amount</label>
                                        <input type="number" step="0.01" name="balance" id="edit-balance" class="form-control" placeholder="0">
                                    </div>
                                </div>

                                <!-- Permissions Column -->
                                <div class="col-lg-4">
                                    <h4 class="mb-3 text-uppercase text-muted" style="border-bottom: 2px solid #ddd; padding-bottom: 5px;">Permissions</h4>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">User:</label>
                                        <input type="text" name="assigned_user" id="edit-assigned_user" class="form-control">
                                    </div>

                                    <div class="mt-4 pt-2">
                                        <button type="submit" class="btn btn-primary w-100">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row row-cards mb-4">
            <div class="col-md-4">
                <div class="card border-0 text-white" style="background-color: #337a5b;">
                    <div class="card-body p-3 text-center">
                        <div class="h1 mb-0 fw-bold">{{ $activeCount }}</div>
                        <div class="text-uppercase fw-bold" style="font-size: 0.8rem;">ACTIVE CHART OF ACCOUNTS</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 text-white" style="background-color: #337a5b;">
                    <div class="card-body p-3 text-center">
                        <div class="h1 mb-0 fw-bold">PKR {{ number_format($totalBalance, 2) }}</div>
                        <div class="text-uppercase fw-bold" style="font-size: 0.8rem;">TOTAL BALANCE</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 text-white" style="background-color: #337a5b;">
                    <div class="card-body p-3 text-center">
                        <div class="h1 mb-0 fw-bold">{{ $inactiveCount }}</div>
                        <div class="text-uppercase fw-bold" style="font-size: 0.8rem;">INACTIVE CHART OF ACCOUNTS</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        @livewire('financials.chart-of-accounts')

        <!-- Create Modal -->
        <div class="modal modal-blur fade" id="modal-create-account" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Chart of Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('financials.chart-of-accounts.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <!-- Basic Column -->
                                <div class="col-lg-4 border-end">
                                    <h4 class="mb-3 text-uppercase text-muted" style="border-bottom: 2px solid #ddd; padding-bottom: 5px;">Basic</h4>
                                    
                                    <div class="mb-3">
                                        <label class="form-label required">Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}">
                                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Type</label>
                                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                            <option value="Asset" {{ old('type') == 'Asset' ? 'selected' : '' }}>Assets</option>
                                            <option value="Liability" {{ old('type') == 'Liability' ? 'selected' : '' }}>Liability</option>
                                            <option value="Equity" {{ old('type') == 'Equity' ? 'selected' : '' }}>Equity</option>
                                            <option value="Revenue" {{ old('type') == 'Revenue' ? 'selected' : '' }}>Revenue</option>
                                            <option value="Expense" {{ old('type') == 'Expense' ? 'selected' : '' }}>Expense</option>
                                        </select>
                                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Opening Balance Column -->
                                <div class="col-lg-4 border-end">
                                    <h4 class="mb-3 text-uppercase text-muted" style="border-bottom: 2px solid #ddd; padding-bottom: 5px;">Opening Balance</h4>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Payment Mode</label>
                                        <select name="payment_mode" class="form-select @error('payment_mode') is-invalid @enderror">
                                            <option value="Cheque" {{ old('payment_mode') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                            <option value="Cash" {{ old('payment_mode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="Bank Transfer" {{ old('payment_mode') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        </select>
                                        @error('payment_mode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Amount</label>
                                        <input type="number" step="0.01" name="balance" class="form-control @error('balance') is-invalid @enderror" placeholder="0" value="{{ old('balance', 0) }}">
                                        @error('balance') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Permissions Column -->
                                <div class="col-lg-4">
                                    <h4 class="mb-3 text-uppercase text-muted" style="border-bottom: 2px solid #ddd; padding-bottom: 5px;">Permissions</h4>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">User:</label>
                                        <input type="text" name="assigned_user" class="form-control @error('assigned_user') is-invalid @enderror" value="{{ old('assigned_user') }}">
                                        @error('assigned_user') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mt-4 pt-2">
                                        <button type="submit" class="btn btn-success w-100">
                                            Create
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('page-scripts')
<script>
    function openEditModal(account) {
        // Populate form fields
        document.getElementById('edit-name').value = account.name;
        document.getElementById('edit-description').value = account.description || '';
        document.getElementById('edit-type').value = account.type;
        document.getElementById('edit-balance').value = account.balance;
        document.getElementById('edit-payment_mode').value = account.payment_mode || '';
        document.getElementById('edit-assigned_user').value = account.assigned_user || '';
        
        // Handle Status Checkbox
        document.getElementById('edit-status').checked = account.status == 1;

        // Set Form Action
        let form = document.getElementById('edit-account-form');
        let updateUrl = "{{ route('financials.chart-of-accounts.update', 'ID_PLACEHOLDER') }}";
        form.action = updateUrl.replace('ID_PLACEHOLDER', account.id);
    }
</script>
@endpush