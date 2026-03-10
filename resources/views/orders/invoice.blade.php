@extends('layouts.tabler')

@section('content')

<div class="container-fluid">

<h3>Invoice #{{ $order->invoice_no }}</h3>

<p>Customer ID: {{ $order->customer_id }}</p>
<p>Order Date: {{ $order->order_date }}</p>

<table class="table table-bordered">

<thead>
<tr>
<th>Product</th>
<th>Qty</th>
<th>Unit Cost</th>
<th>Total</th>
</tr>
</thead>

<tbody>

@foreach($orderDetails as $item)

<tr>
<td>{{ $item->product_name }}</td>
<td>{{ $item->quantity }}</td>
<td>{{ $item->unitcost }}</td>
<td>{{ $item->total }}</td>
</tr>

@endforeach

</tbody>

</table>

</div>

@endsection