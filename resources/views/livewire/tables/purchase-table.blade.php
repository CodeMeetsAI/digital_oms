<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            @foreach(['all', 'cancelled', 'completed', 'fulfilled', 'partially_fulfilled', 'partially_returned', 'returned', 'unfulfilled'] as $tab)
                <li class="nav-item">
                    <a href="#" wire:click.prevent="setStatus('{{ $tab }}')" class="nav-link {{ $status === $tab ? 'active' : '' }}">
                        {{ ucwords(str_replace('_', ' ', $tab)) }} ({{ $counts[$tab] ?? 0 }})
                    </a>
                </li>
            @endforeach
            <li class="nav-item ms-auto">
                <a href="#" class="nav-link border-0 text-success fw-bold d-flex align-items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
                    </svg>
                    Apply Filters
                </a>
            </li>
        </ul>
    </div>

    <div class="card-body border-bottom py-3">
        <div class="d-flex justify-content-end align-items-center gap-2">
            <div class="input-icon" style="width: 300px;">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                </span>
                <input type="text" wire:model.live="search" class="form-control" placeholder="Search by Purchase #">
            </div>

            <button type="button" class="btn btn-success d-none d-sm-inline-block fw-bold" data-bs-toggle="modal" data-bs-target="#modal-purchase-order">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                CREATE PURCHASE ORDER
            </button>
            <div class="dropdown">
                <button type="button" class="btn dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                    MORE
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#">Action</a>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="align-middle">
                        <a wire:click.prevent="sortBy('date')" href="#" role="button">
                            {{ __('PURCHASE DATE') }}
                            @include('inclues._sort-icon', ['field' => 'date'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle">{{ __('ATTACHMENTS') }}</th>
                    <th scope="col" class="align-middle">
                        <a wire:click.prevent="sortBy('supplier_id')" href="#" role="button">
                            {{ __('SUPPLIER') }}
                            @include('inclues._sort-icon', ['field' => 'supplier_id'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle">
                        <a wire:click.prevent="sortBy('purchase_no')" href="#" role="button">
                            {{ __('PO #') }}
                            @include('inclues._sort-icon', ['field' => 'purchase_no'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle">
                        <a wire:click.prevent="sortBy('po_reference')" href="#" role="button">
                            {{ __('PO REFERENCE #') }}
                            @include('inclues._sort-icon', ['field' => 'po_reference'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle">
                        <a wire:click.prevent="sortBy('payment_status')" href="#" role="button">
                            {{ __('PAYMENT STATUS') }}
                            @include('inclues._sort-icon', ['field' => 'payment_status'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle">{{ __('PAYMENT ACTION') }}</th>
                    <th scope="col" class="align-middle">{{ __('REFUND PAYMENT ACTION') }}</th>
                    <th scope="col" class="align-middle">
                        <a wire:click.prevent="sortBy('shipment_status')" href="#" role="button">
                            {{ __('SHIPMENT STATUS') }}
                            @include('inclues._sort-icon', ['field' => 'shipment_status'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle">{{ __('LOCATION') }}</th>
                    <th scope="col" class="align-middle">
                        <a wire:click.prevent="sortBy('total_amount')" href="#" role="button">
                            {{ __('AMOUNT') }}
                            @include('inclues._sort-icon', ['field' => 'total_amount'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle">{{ __('TAX') }}</th>
                    <th scope="col" class="align-middle">{{ __('BALANCE') }}</th>
                    <th scope="col" class="align-middle">{{ __('CREATED') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchases as $purchase)
                    <tr>
                        <td class="align-middle">
                            {{ $purchase->date->format('d M Y') }}
                        </td>
                        <td class="align-middle text-center">
                            {{-- Placeholder for attachments --}}
                            <span class="badge bg-secondary">0</span>
                        </td>
                        <td class="align-middle">
                            {{ $purchase->supplier->name }}
                        </td>
                        <td class="align-middle">
                            <a href="{{ route('purchases.edit', $purchase) }}" class="text-decoration-none">
                                {{ $purchase->purchase_no }}
                            </a>
                        </td>
                        <td class="align-middle">
                            {{ $purchase->po_reference ?? '-' }}
                        </td>
                        <td class="align-middle">
                            @php
                                $paymentBadge = match($purchase->payment_status) {
                                    \App\Enums\PaymentStatus::PAID => 'bg-green',
                                    \App\Enums\PaymentStatus::PARTIAL => 'bg-yellow',
                                    \App\Enums\PaymentStatus::REFUNDED => 'bg-purple',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $paymentBadge }} text-white">
                                {{ $purchase->payment_status->label() }}
                            </span>
                        </td>
                        <td class="align-middle">
                             {{-- Payment Action --}}
                        </td>
                        <td class="align-middle">
                             {{-- Refund Action --}}
                        </td>
                        <td class="align-middle">
                             @php
                                $shipmentBadge = match($purchase->shipment_status) {
                                    \App\Enums\ShipmentStatus::FULFILLED => 'bg-green',
                                    \App\Enums\ShipmentStatus::PARTIALLY_FULFILLED => 'bg-yellow',
                                    \App\Enums\ShipmentStatus::RETURNED => 'bg-red',
                                    \App\Enums\ShipmentStatus::PARTIALLY_RETURNED => 'bg-orange',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $shipmentBadge }} text-white">
                                {{ $purchase->shipment_status->label() }}
                            </span>
                        </td>
                        <td class="align-middle">
                            {{-- Location placeholder --}}
                            Main Warehouse
                        </td>
                        <td class="align-middle">
                            {{ Number::currency($purchase->total_amount, 'EUR') }}
                        </td>
                        <td class="align-middle">
                            {{ Number::currency($purchase->tax_amount, 'EUR') }}
                        </td>
                        <td class="align-middle">
                            {{ Number::currency($purchase->due_amount, 'EUR') }}
                        </td>
                        <td class="align-middle">
                            {{ $purchase->createdBy->name ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center py-5">
                            <div class="empty">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                                </div>
                                <p class="empty-title">No Purchases</p>
                                <p class="empty-subtitle text-secondary">
                                    Get started by creating a new purchase
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
            Showing <span>{{ $purchases->firstItem() }}</span> to <span>{{ $purchases->lastItem() }}</span> of <span>{{ $purchases->total() }}</span> entries
        </p>
        <ul class="pagination m-0 ms-auto">
            {{ $purchases->links() }}
        </ul>
    </div>
</div>
