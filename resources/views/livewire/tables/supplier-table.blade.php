<div class="card">
    <div class="card-header border-bottom">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <!-- Left: Apply Filters -->
            <div>
                <a href="#" class="text-success fw-bold text-decoration-none d-flex align-items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
                    </svg>
                    Apply Filters
                </a>
            </div>

            <!-- Right: Search, Dropdown, Button -->
            <div class="d-flex align-items-center gap-2">
                <!-- Search -->
                <div class="input-icon">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                    </span>
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Search by Supplier ID" aria-label="Search">
                </div>

                <!-- Dropdown -->
                <select class="form-select w-auto">
                    <option value="">Supplier ID</option>
                    <option value="name">Name</option>
                    <option value="phone">Phone</option>
                </select>

                <!-- New Supplier Button -->
                <a href="{{ route('suppliers.create') }}" class="btn btn-success text-white fw-bold d-flex align-items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 5l0 14"></path>
                        <path d="M5 12l14 0"></path>
                    </svg>
                    NEW SUPPLIER
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead style="background-color: #e6f7ed; color: #1f2937;">
                <tr>
                    <th class="w-1">ID</th>
                    <th>NAME</th>
                    <th>STATUS</th>
                    <th>COMPANY</th>
                    <th>NUMBER</th>
                    <th>EMAIL ADDRESS</th>
                    <th>ADDRESS</th>
                    <th>CATEGORY</th>
                    <th>TOTAL ORDERS</th>
                    <th>PURCHASES</th>
                    <th>BALANCE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                    <tr>
                        <td>#{{ $supplier->id }}</td>
                        <td class="fw-bold">{{ $supplier->name }}</td>
                        <td>
                            @if($supplier->status)
                                <span class="badge bg-green-lt">Active</span>
                            @else
                                <span class="badge bg-red-lt">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $supplier->shopname ?? '-' }}</td>
                        <td>{{ $supplier->phone ?? '-' }}</td>
                        <td>{{ $supplier->email ?? '-' }}</td>
                        <td>{{ $supplier->address ?? '-' }}</td>
                        <td>{{ $supplier->supplierCategory->name ?? 'Default' }}</td>
                        <td class="text-center">{{ $supplier->purchases_count }}</td>
                        <td>PKR {{ number_format($supplier->purchases_sum_total_amount ?? 0, 2) }}</td>
                        <td>PKR 0.00</td> <!-- Balance logic TBD -->
                        <td>
                            <a href="{{ route('suppliers.show', $supplier) }}" class="text-decoration-none">View Ledger</a>
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="text-decoration-none ms-2">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center py-5">
                            <div class="empty">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                                </div>
                                <p class="empty-title">No stock suppliers</p>
                                <p class="empty-subtitle text-secondary">
                                    Get started by creating a new supplier
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Show 
            <select wire:model.live="perPage" class="form-select form-select-sm d-inline-block w-auto mx-2">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            entries
        </p>
        <div class="ms-auto">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
