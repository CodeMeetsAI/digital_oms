<div class="card">
    <div class="card-body border-bottom py-3">
        <div class="d-flex justify-content-end align-items-center gap-2">
            <!-- Apply Filters Button -->
            <button class="btn btn-outline-success border-0 text-success fw-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-5.31 5.31a1 1 0 0 0 -.293 .707v5.586l-4 4v-9.586a1 1 0 0 0 -.293 -.707l-5.31 -5.31a2 2 0 0 1 -.586 -1.414v-2.172z"></path>
                </svg>
                Apply Filters
            </button>

            <!-- Search Group -->
            <div class="input-group input-group-flat" style="width: 400px;">
                <span class="input-group-text bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                        <path d="M21 21l-6 -6"></path>
                    </svg>
                </span>
                <input type="text" wire:model.live="search" class="form-control ps-0" aria-label="Search" placeholder="Search by {{ $searchType === 'id' ? 'Customer ID' : ucfirst($searchType) }}">
                <select wire:model.live="searchType" class="form-select w-auto border-start-0 ps-2 fw-bold text-dark">
                    <option value="id">Customer ID</option>
                    <option value="name">Name</option>
                    <option value="email">Email</option>
                    <option value="phone">Phone</option>
                </select>
            </div>

            <!-- New Customer Button -->
            <a href="{{ route('customers.create') }}" class="btn btn-success d-none d-sm-inline-block text-uppercase fw-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                New Customer
            </a>
        </div>
    </div>

    <x-spinner.loading-spinner/>

    <div class="table-responsive">
        <table wire:loading.remove class="table table-vcenter text-nowrap datatable table-hover">
            <thead class="bg-light">
            <tr>
                <th scope="col" class="align-middle text-center">
                    <a wire:click.prevent="sortBy('id')" href="#" role="button" class="text-decoration-none text-muted fw-bold">
                        {{ __('ID') }}
                        @include('inclues._sort-icon', ['field' => 'id'])
                    </a>
                </th>
                <th scope="col" class="align-middle">
                    <a wire:click.prevent="sortBy('name')" href="#" role="button" class="text-decoration-none text-muted fw-bold">
                        {{ __('NAME') }}
                        @include('inclues._sort-icon', ['field' => 'name'])
                    </a>
                </th>
                <th scope="col" class="align-middle text-center text-muted fw-bold">
                    {{ __('STATUS') }}
                </th>
                <th scope="col" class="align-middle text-muted fw-bold">
                    <a wire:click.prevent="sortBy('phone')" href="#" role="button" class="text-decoration-none text-muted">
                        {{ __('NUMBER') }}
                        @include('inclues._sort-icon', ['field' => 'phone'])
                    </a>
                </th>
                <th scope="col" class="align-middle text-muted fw-bold">
                    <a wire:click.prevent="sortBy('email')" href="#" role="button" class="text-decoration-none text-muted">
                        {{ __('EMAIL') }}
                        @include('inclues._sort-icon', ['field' => 'email'])
                    </a>
                </th>
                <th scope="col" class="align-middle text-center text-muted fw-bold">
                    {{ __('CATEGORY') }}
                </th>
                <th scope="col" class="align-middle text-center text-muted fw-bold">
                    {{ __('BLACKLISTED') }}
                </th>
                <th scope="col" class="align-middle text-center text-muted fw-bold">
                    {{ __('TOTAL ORDERS') }}
                </th>
                <th scope="col" class="align-middle text-center text-muted fw-bold">
                    {{ __('TOTAL SALES') }}
                </th>
                <th scope="col" class="align-middle text-center text-muted fw-bold">
                    {{ __('BALANCE') }}
                </th>
                <th scope="col" class="align-middle text-center text-muted fw-bold">
                    {{ __('ACTIONS') }}
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td class="align-middle text-center">
                        {{ $customer->id }}
                    </td>
                    <td class="align-middle fw-bold">
                        {{ $customer->name }}
                    </td>
                    <td class="align-middle text-center">
                        @if($customer->status)
                            <span class="badge bg-green-lt">Active</span>
                        @else
                            <span class="badge bg-red-lt">Inactive</span>
                        @endif
                    </td>
                    <td class="align-middle">
                        {{ $customer->phone }}
                    </td>
                    <td class="align-middle">
                        {{ $customer->email }}
                    </td>
                     <td class="align-middle text-center">
                        {{ $customer->category ? $customer->category->name : '--' }}
                    </td>
                    <td class="align-middle text-center">
                         @if($customer->is_blacklisted)
                            <span class="text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                   <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                            </span>
                        @else
                            --
                        @endif
                    </td>
                     <td class="align-middle text-center">
                        {{ $customer->orders_count }}
                    </td>
                     <td class="align-middle text-center">
                        {{ number_format($customer->total_sales / 100, 2) }}
                    </td>
                     <td class="align-middle text-center">
                        {{ number_format($customer->opening_balance + ($customer->total_due / 100), 2) }}
                    </td>
                    <td class="align-middle text-center" style="width: 10%">
                        <div class="btn-list flex-nowrap justify-content-center">
                            <x-button.show class="btn-icon" route="{{ route('customers.show', $customer) }}"/>
                            <x-button.edit class="btn-icon" route="{{ route('customers.edit', $customer) }}"/>
                            <x-button.delete class="btn-icon" route="{{ route('customers.destroy', $customer) }}"/>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="align-middle text-center" colspan="11">
                        <div class="empty">
                            <div class="empty-img"><img src="{{ asset('assets/img/undraw_printing_invoices_5r4r.svg') }}" height="128"  alt="">
                            </div>
                            <p class="empty-title">No stock customers</p>
                            <p class="empty-subtitle text-muted">
                                Get started by creating a new customer
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
            Showing <span>{{ $customers->firstItem() }}</span> to <span>{{ $customers->lastItem() }}</span> of <span>{{ $customers->total() }}</span> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            {{ $customers->links() }}
        </ul>
    </div>
</div>
