<div>
    <!-- Page Actions Toolbar -->
    <div class="d-flex justify-content-end mb-3 gap-2">
         <!-- Filter Button -->
         <div class="dropdown">
             <button class="btn btn-warning btn-icon position-relative" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-5.31 5.314v3.6a2 2 0 0 1 -.586 1.414l-2 2a2 2 0 0 1 -3.414 -1.414v-5.6a2 2 0 0 1 -.586 -1.414l-5.31 -5.314z"></path>
                </svg>
                @if($this->activeFiltersCount > 0)
                    <span class="badge bg-red badge-notification badge-blink">{{ $this->activeFiltersCount }}</span>
                @endif
             </button>
             <div class="dropdown-menu dropdown-menu-end p-3" style="width: 300px;">
                <form wire:submit.prevent="applyFilters">
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <input type="text" wire:model="filterName" class="form-control" placeholder="Search by name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type:</label>
                        <select wire:model="filterType" class="form-select">
                            <option value="">All Types</option>
                            <option value="Asset">Asset</option>
                            <option value="Liability">Liability</option>
                            <option value="Equity">Equity</option>
                            <option value="Revenue">Revenue</option>
                            <option value="Expense">Expense</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Balance:</label>
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Min</span>
                                <input type="number" wire:model="minBalance" class="form-control" placeholder="0">
                            </div>
                            <span class="text-muted">-</span>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Max</span>
                                <input type="number" wire:model="maxBalance" class="form-control" placeholder="0">
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success w-100">Filter</button>
                        <button type="button" class="btn btn-danger w-100" wire:click="resetFilters">Reset Filters</button>
                    </div>
                </form>
            </div>
         </div>

         <!-- Create Button -->
         <button type="button" class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#modal-create-account">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 5l0 14"></path>
                <path d="M5 12l14 0"></path>
            </svg>
            Create Chart Of Account
        </button>

        <!-- Transactions Button -->
        <button type="button" class="btn btn-success fw-bold">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrows-left-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M21 14l-4 -4l4 -4"></path>
                <path d="M14 10h7"></path>
                <path d="M3 10l4 4l-4 4"></path>
                <path d="M10 14h-7"></path>
            </svg>
            Transactions
        </button>
    </div>

    <div class="card">
        <div class="card-header border-bottom-0">
            <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
                <!-- Tabs/Filters -->
                <div class="btn-group" role="group">
                    <button wire:click="setFilterStatus('all')" type="button" class="btn {{ $filterStatus === 'all' ? 'btn-dark' : 'btn-light' }} fw-bold">All</button>
                    <button wire:click="setFilterStatus('active')" type="button" class="btn {{ $filterStatus === 'active' ? 'btn-dark' : 'btn-light' }}">Active</button>
                    <button wire:click="setFilterStatus('inactive')" type="button" class="btn {{ $filterStatus === 'inactive' ? 'btn-dark' : 'btn-light' }}">Inactive</button>
                </div>

                <!-- Right Side Controls -->
                <div class="d-flex align-items-center gap-2">
                     <select wire:model.live="perPage" class="form-select form-select-sm d-inline-block w-auto me-2">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th>
                            Name
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9l4 -4l4 4" /><path d="M16 15l-4 4l-4 -4" /></svg>
                        </th>
                        <th>
                            Type
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9l4 -4l4 4" /><path d="M16 15l-4 4l-4 -4" /></svg>
                        </th>
                        <th>
                            Description
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9l4 -4l4 4" /><path d="M16 15l-4 4l-4 -4" /></svg>
                        </th>
                        <th class="text-end">
                            Balance
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9l4 -4l4 4" /><path d="M16 15l-4 4l-4 -4" /></svg>
                        </th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $account->name }}</div>
                                @if($account->status)
                                    <div class="text-success small">
                                        <span class="status-dot status-dot-animated bg-success me-1"></span> Active
                                    </div>
                                @else
                                    <div class="text-secondary small">
                                        <span class="status-dot me-1"></span> Inactive
                                    </div>
                                @endif
                            </td>
                            <td>{{ $account->type }}</td>
                            <td>{{ $account->description }}</td>
                            <td class="text-end">PKR {{ number_format($account->balance, 2) }}</td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <button class="btn btn-white btn-icon" onclick="openEditModal({{ json_encode($account) }})" data-bs-toggle="modal" data-bs-target="#modal-edit-account" aria-label="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            {{ $accounts->links() }}
        </div>
    </div>
</div>
