<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackingListController extends Controller
{
    public function generate($orderId)
    {
        // Tenant DB select
        $user = auth()->user();
        $tenantDatabase = $user->tenant_db ?? 'tenantumico';
        config(['database.connections.tenant.database' => $tenantDatabase]);

        // Order fetch
       $order = DB::connection('tenant')
    ->table('orders')
    ->where('invoice_no', 'INV-' . $orderId) // invoice_no ke saath match
    ->first();

if (!$order) {
    return back()->with('error', 'Order not found!');
}

        // Order items fetch
        $orderItems = DB::connection('tenant')->table('order_details')
            ->where('order_id', $orderId)
            ->get();

        return view('orders.packing-list', compact('order', 'orderItems'));
    }
}