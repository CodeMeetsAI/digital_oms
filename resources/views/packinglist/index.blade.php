@extends('layouts.app')

@section('content')
<h1>Packing List Orders</h1>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Invoice No</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <td>
    @foreach($order['line_items'] as $item)
        {{ $item['name'] }} ({{ $item['quantity'] }})<br>
    @endforeach

    <a href="{{ route('orders.packing-list', $order['id']) }}" class="btn btn-sm btn-secondary mt-2">
        Generate Packing List
    </a>
</td>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->invoice_no }}</td>
            <td>{{ $order->order_date }}</td>
            <td>
                <a href="{{ route('packing.list.download', $order->id) }}" target="_blank">Download Packing List</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection