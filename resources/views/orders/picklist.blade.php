@extends('layouts.tabler')

@section('content')

<div class="page-header d-print-none">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title mb-1">Pick List</h2>
                <div class="text-muted">Professional WooCommerce Order Picking Dashboard</div>
            </div>
            <div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">Back to Orders</a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row row-deck row-cards mb-3">
            <div class="col-sm-6 col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">Orders</div>
                        <div class="h1 mb-0">{{ $totalOrders }}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">Products</div>
                        <div class="h1 mb-0">{{ $totalProducts }}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">Orders Value</div>
                        <div class="h3 mb-0">{{ number_format($ordersTotalValue, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">Avg Order</div>
                        <div class="h3 mb-0">{{ number_format($averageOrderValue, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">Shipping Total</div>
                        <div class="h3 mb-0">{{ number_format($shippingTotal, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <div class="text-muted">Avg Shipping</div>
                        <div class="h3 mb-0">{{ number_format($averageShipping, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('picklist.index') }}">
                    <div class="row g-2">
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">Order Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="progress" class="form-control">
                                <option value="">Progress</option>
                                <option value="not_started" {{ request('progress') == 'not_started' ? 'selected' : '' }}>0%</option>
                                <option value="in_progress" {{ request('progress') == 'in_progress' ? 'selected' : '' }}>1% - 99%</option>
                                <option value="completed" {{ request('progress') == 'completed' ? 'selected' : '' }}>100%</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="priority" class="form-control">
                                <option value="">Priority</option>
                                <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Urgent" {{ request('priority') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="assigned_user_id" class="form-control">
                                <option value="">Assigned User</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ request('assigned_user_id') == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Search invoice / customer / city"
                                   value="{{ request('search') }}">
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Priority</th>
                            <th>Progress</th>
                            <th>Assigned To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <div><strong>#{{ $order->id }}</strong></div>
                                    <small class="text-muted">{{ $order->invoice_no }}</small>
                                </td>

                                <td>
                                    <div>{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') : '-' }}</div>
                                    <small class="text-muted">
                                        {{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('h:i A') : '' }}
                                    </small>
                                </td>

                                <td>
                                    <div><strong>{{ $order->customer_name ?? '-' }}</strong></div>
                                    <small class="text-muted">{{ $order->customer_email ?? '' }}</small>
                                    <div><small class="text-muted">{{ $order->customer_city ?? '' }}</small></div>
                                </td>

                                <td>
                                    @if((int) $order->order_status === 1)
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>

                                <td>{{ $order->total_products ?? 0 }}</td>

                                <td>{{ number_format((float) $order->total, 2) }}</td>

                                <td style="min-width: 150px;">
                                    <form action="{{ route('picklist.priority', $order->id) }}" method="POST">

                                        @csrf
                                        <select name="pick_priority" class="form-control form-control-sm" onchange="this.form.submit()">
                                            <option value="">Select</option>
                                            <option value="Low" {{ $order->pick_priority == 'Low' ? 'selected' : '' }}>Low</option>
                                            <option value="Medium" {{ $order->pick_priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="High" {{ $order->pick_priority == 'High' ? 'selected' : '' }}>High</option>
                                            <option value="Urgent" {{ $order->pick_priority == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                        </select>
                                    </form>
                                </td>

                                <td style="min-width: 180px;">
                                  <form action="{{ route('picklist.progress', $order->id) }}" method="POST">
                                        @csrf
                                        <input type="number"
                                               name="pick_progress"
                                               value="{{ $order->pick_progress ?? 0 }}"
                                               min="0"
                                               max="100"
                                               class="form-control form-control-sm"
                                               style="width: 80px;">
                                        <button class="btn btn-sm btn-primary">Save</button>
                                    </form>

                                    <div class="progress mt-2" style="height: 8px;">
                                        <div class="progress-bar"
                                             role="progressbar"
                                             style="width: {{ (int)($order->pick_progress ?? 0) }}%;"
                                             aria-valuenow="{{ (int)($order->pick_progress ?? 0) }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <small>{{ (int)($order->pick_progress ?? 0) }}%</small>
                                </td>

                                <td style="min-width: 180px;">
                                <form action="{{ route('picklist.assign', $order->id) }}" method="POST">
                                        @csrf
                                        <select name="assigned_user_id" class="form-control form-control-sm" onchange="this.form.submit()">
                                            <option value="">Select</option>
                                            @foreach($users as $u)
                                                <option value="{{ $u->id }}" {{ $order->assigned_user_id == $u->id ? 'selected' : '' }}>
                                                    {{ $u->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>

                                <td>
                                    <a href="{{ route('orders.picklist', $order->id) }}"
                                       class="btn btn-primary btn-sm"
                                       target="_blank">
                                        Pick Order
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No pick orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="card-footer">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

    </div>
</div>

@endsection