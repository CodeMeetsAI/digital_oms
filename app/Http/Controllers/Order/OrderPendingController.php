<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderPendingController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = Order::query()
            ->where('order_status', OrderStatus::PENDING)
            ->with('customer')
            ->latest()
            ->get();

        return view('orders.pending-orders', [
            'orders' => $orders,
        ]);
    }
}
