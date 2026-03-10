@extends('layouts.tabler')

@section('content')

<div class="page-header d-print-none">
    <div class="container-fluid">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Orders</h2>
            </div>
            <div class="col-auto d-flex gap-2">
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                        Print Documents
                    </button>

                    <div class="dropdown-menu p-3" style="min-width: 220px;">
                        @forelse(<a href="{{ route('orders.picklist', ['order' => $order->id], false) }}" 
   class="btn btn-sm btn-primary" target="_blank">
   PickList
</a>

                            <a class="dropdown-item"
                               href="{{ route('orders.invoice', $order->id) }}"
                               target="_blank">
                               Invoice - {{ $order->invoice_no }}
                            </a>
                        @empty
                            <span class="dropdown-item text-muted">No orders found</span>
                        @endforelse
                    </div>
                </div>

                <form action="{{ route('orders.sync') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Sync WooCommerce Orders</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-fluid">

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('orders.index') }}">
                    <div class="row g-2">
                        <div class="col-md-2">
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending (0)</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Completed (1)</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="amount_sort" class="form-control">
                                <option value="">Sort Amount</option>
                                <option value="asc" {{ request('amount_sort') == 'asc' ? 'selected' : '' }}>Low → High</option>
                                <option value="desc" {{ request('amount_sort') == 'desc' ? 'selected' : '' }}>High → Low</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Customer / Email / Phone / City / Invoice"
                                value="{{ request('search') }}"
                            >
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Orders</h3>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Invoice No</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment Type</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->invoice_no ?? '-' }}</td>
                                <td>{{ $order->customer_name ?? '-' }}</td>
                                <td>{{ $order->customer_email ?? '-' }}</td>
                                <td>{{ $order->customer_phone ?? '-' }}</td>
                                <td>{{ $order->customer_city ?? '-' }}</td>
                                <td style="min-width: 220px;">{{ $order->customer_address ?? '-' }}</td>
                                <td>{{ number_format((float)($order->total ?? 0), 2) }}</td>
                                <td>
                                    @if((int) $order->order_status === 1)
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $order->payment_type ?? '-' }}</td>
                                <td>
                                    {{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('Y-m-d H:i') : '-' }}
                                </td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('orders.picklist', $order->id) }}" class="btn btn-sm btn-primary" target="_blank">PickList</a>
<a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-sm btn-success" target="_blank">Invoice</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection