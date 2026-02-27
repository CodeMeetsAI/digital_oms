<div>
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a href="#" class="nav-link {{ $status === 'all' ? 'active' : '' }}" wire:click.prevent="setStatus('all')">All ({{ $counts['all'] ?? 0 }})</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ $status === 'ready_to_ship' ? 'active' : '' }}" wire:click.prevent="setStatus('ready_to_ship')">Ready to Ship ({{ $counts['ready_to_ship'] ?? 0 }})</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ $status === 'pending' ? 'active' : '' }}" wire:click.prevent="setStatus('pending')">Pending ({{ $counts['pending'] ?? 0 }})</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ $status === 'booked' ? 'active' : '' }}" wire:click.prevent="setStatus('booked')">Booked ({{ $counts['booked'] ?? 0 }})</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ $status === 'shipped' ? 'active' : '' }}" wire:click.prevent="setStatus('shipped')">Shipped ({{ $counts['shipped'] ?? 0 }})</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ $status === 'delivered' ? 'active' : '' }}" wire:click.prevent="setStatus('delivered')">Delivered ({{ $counts['delivered'] ?? 0 }})</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ $status === 'returned' ? 'active' : '' }}" wire:click.prevent="setStatus('returned')">Returned ({{ $counts['returned'] ?? 0 }})</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ $status === 'void' ? 'active' : '' }}" wire:click.prevent="setStatus('void')">Void ({{ $counts['void'] ?? 0 }})</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ $status === 'delivery_failed' ? 'active' : '' }}" wire:click.prevent="setStatus('delivery_failed')">Delivery Failed ({{ $counts['delivery_failed'] ?? 0 }})</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link {{ $status === 'restocked' ? 'active' : '' }}" wire:click.prevent="setStatus('restocked')">Restocked ({{ $counts['restocked'] ?? 0 }})</a>
            </li>
        </ul>
    </div>

    <div class="card-body border-bottom py-3">
        <div class="d-flex">
            <div class="text-secondary">
                Showing {{ $orders->firstItem() ?? 0 }} of {{ $orders->total() }} orders
            </div>
            <div class="ms-auto text-secondary">
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox">
                    <span class="form-check-label">Show more options</span>
                </label>
                <span class="form-help" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Show more options">?</span>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-vcenter card-table table-nowrap">
            <thead style="background-color: #e6f7f4; color: #0ca678; font-weight: bold; font-size: 0.75rem;">
                <tr>
                    <th class="w-1"><input class="form-check-input" type="checkbox"></th>
                    <th>FULFILLMENT STATUS</th>
                    <th>STORE</th>
                    <th>ORDER ID</th>
                    <th>FBR POS ID</th>
                    <th>ORDER DATE</th>
                    <th>DELIVERY STATUS</th>
                    <th>ITEMS</th>
                    <th>CUSTOMER</th>
                    <th>SHIPPING ADDRESS</th>
                    <th>CITY</th>
                    <th>TOTAL</th>
                    <th>TAX</th>
                    <th>BALANCE</th>
                    <th>TAGS</th>
                    <th>COURIER</th>
                    <th>PAYMENT STATUS</th>
                    <th>LOCATION</th>
                    <th>SALES REP</th>
                    <th>COMMENTS</th>
                    <th>CREATED BY</th>
                    <th>SYSTEM CREATION DATE</th>
                    <th>CONFIRM BY</th>
                    <th>PAYMENT ACTION</th>
                    <th>WEIGHT</th>
                    <th>BOOKING DETAILS</th>
                    <th>INTERNAL NOTES</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td><input class="form-check-input" type="checkbox"></td>
                    <td>
                        <span class="badge bg-green-lt">Fulfilled</span>
                    </td>
                    <td>My Store</td>
                    <td>{{ $order->invoice_no }}</td>
                    <td>-</td>
                    <td>{{ $order->order_date ? $order->order_date->format('d M Y') : '-' }}</td>
                    <td>{{ $order->order_status }}</td>
                    <td>{{ $order->details->count() ?? 0 }}</td>
                    <td>{{ $order->customer->name ?? '-' }}</td>
                    <td>{{ $order->customer->shipping_address_line_1 ?? $order->customer->address ?? '-' }}</td>
                    <td>{{ $order->customer->shipping_city ?? $order->customer->billing_city ?? '-' }}</td>
                    <td>{{ number_format($order->total, 2) }}</td>
                    <td>{{ number_format($order->vat, 2) }}</td>
                    <td>{{ number_format($order->due, 2) }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>{{ $order->due > 0 ? 'Unpaid' : 'Paid' }}</td>
                    <td>{{ $order->customer->shipping_city ?? $order->customer->billing_city ?? '-' }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>{{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            @empty
                <tr>
                    <td colspan="27" class="text-center py-5">
                        <div class="empty">
                            <div class="empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="9" y1="9" x2="10" y2="9" /><line x1="9" y1="13" x2="15" y2="13" /><line x1="9" y1="17" x2="15" y2="17" /></svg>
                            </div>
                            <p class="empty-title">No orders yet</p>
                            <p class="empty-subtitle text-secondary">
                                Orders will be displayed here when you start making sales.
                            </p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex align-items-center">
        <div class="text-secondary me-auto">
            Show
            <div class="mx-2 d-inline-block">
                <select wire:model.live="perPage" class="form-select form-select-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            Entries
        </div>
        
        <ul class="pagination m-0 ms-auto">
            {{ $orders->links() }}
        </ul>
        
        <div class="ms-3 text-secondary">
            Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }} ({{ $orders->total() }} total entries)
        </div>
    </div>
</div>
