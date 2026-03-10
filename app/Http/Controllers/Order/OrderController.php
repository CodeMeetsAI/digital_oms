<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $tenantDatabase = $user->tenant_db ?? 'tenantumico';
        config(['database.connections.tenant.database' => $tenantDatabase]);

        $query = DB::connection('tenant')
            ->table('orders')
            ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
            ->select(
                'orders.id',
                'orders.invoice_no',
                'orders.order_date',
                'orders.order_status',
                'orders.total_products',
                'orders.sub_total',
                'orders.vat',
                'orders.total',
                'orders.payment_type',
                'orders.pay',
                'orders.due',
                'orders.created_at',
                'orders.updated_at',
                'customers.name as customer_name',
                'customers.email as customer_email',
                DB::raw('COALESCE(customers.billing_phone, customers.phone) as customer_phone'),
                DB::raw('COALESCE(customers.billing_city, customers.shipping_city) as customer_city'),
                DB::raw("TRIM(CONCAT_WS(', ',
                    customers.billing_address_line_1,
                    customers.billing_address_line_2,
                    customers.billing_address_line_3,
                    customers.billing_address_line_4
                )) as customer_address")
            );

        if ($request->status !== null && $request->status !== '') {
            $status = $request->status;

            if ($status === 'pending' || $status === '0') {
                $query->where('orders.order_status', 0);
            } elseif ($status === 'completed' || $status === '1') {
                $query->where('orders.order_status', 1);
            }
        }

        if ($request->from_date && $request->to_date) {
            $query->whereDate('orders.order_date', '>=', $request->from_date)
                  ->whereDate('orders.order_date', '<=', $request->to_date);
        }

        if ($request->search) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('orders.invoice_no', 'like', "%{$search}%")
                  ->orWhere('customers.name', 'like', "%{$search}%")
                  ->orWhere('customers.email', 'like', "%{$search}%")
                  ->orWhere('customers.phone', 'like', "%{$search}%")
                  ->orWhere('customers.billing_phone', 'like', "%{$search}%")
                  ->orWhere('customers.billing_city', 'like', "%{$search}%")
                  ->orWhere('customers.shipping_city', 'like', "%{$search}%")
                  ->orWhere('customers.address', 'like', "%{$search}%")
                  ->orWhere('customers.billing_address_line_1', 'like', "%{$search}%")
                  ->orWhere('customers.billing_address_line_2', 'like', "%{$search}%")
                  ->orWhere('customers.billing_address_line_3', 'like', "%{$search}%")
                  ->orWhere('customers.billing_address_line_4', 'like', "%{$search}%");
            });
        }

        if ($request->amount_sort === 'asc') {
            $query->orderBy('orders.total', 'asc');
        } elseif ($request->amount_sort === 'desc') {
            $query->orderBy('orders.total', 'desc');
        } else {
            $query->orderByDesc('orders.id');
        }

        $orders = $query->get();

        return view('orders.index', compact('orders'));
    }

    public function sync(Request $request)
    {
        $user = auth()->user();
        $tenantDatabase = $user->tenant_db ?? 'tenantumico';
        config(['database.connections.tenant.database' => $tenantDatabase]);

        $integrations = DB::connection('tenant')
            ->table('user_integrations')
            ->where('user_id', $user->id)
            ->where('platform', 'woocommerce')
            ->get();

        if ($integrations->isEmpty()) {
            return redirect()->route('orders.index')
                ->with('error', 'No WooCommerce integrations found.');
        }

        foreach ($integrations as $integration) {
            try {
                $storeUrl = rtrim($integration->store_url, '/');
                $apiUrl = $storeUrl . '/orders';

                $response = Http::timeout(60)->get($apiUrl, [
                    'consumer_key' => $integration->api_key,
                    'consumer_secret' => $integration->api_secret,
                    'per_page' => 100,
                ]);

                if (!$response->successful()) {
                    throw new \Exception("Failed to fetch orders from {$integration->store_name}");
                }

                $orders = $response->json();

                foreach ($orders as $order) {
                    try {
                        DB::connection('tenant')->beginTransaction();

                        $invoiceNo = 'INV-' . ($order['id'] ?? '');

                        $existingOrder = DB::connection('tenant')
                            ->table('orders')
                            ->where('invoice_no', $invoiceNo)
                            ->first();

                        $billingFirstName = $order['billing']['first_name'] ?? '';
                        $billingLastName  = $order['billing']['last_name'] ?? '';
                        $billingName      = trim($billingFirstName . ' ' . $billingLastName);
                        $billingEmail     = $order['billing']['email'] ?? null;
                        $billingPhone     = $order['billing']['phone'] ?? null;

                        $shippingFirstName = $order['shipping']['first_name'] ?? '';
                        $shippingLastName  = $order['shipping']['last_name'] ?? '';
                        $shippingName      = trim($shippingFirstName . ' ' . $shippingLastName);

                        $customer = null;

                        if (!empty($billingEmail)) {
                            $customer = DB::connection('tenant')
                                ->table('customers')
                                ->where('email', $billingEmail)
                                ->first();
                        }

                        if (!$customer && !empty($billingPhone)) {
                            $customer = DB::connection('tenant')
                                ->table('customers')
                                ->where(function ($q) use ($billingPhone) {
                                    $q->where('phone', $billingPhone)
                                      ->orWhere('billing_phone', $billingPhone);
                                })
                                ->first();
                        }

                        $customerData = [
                            'name' => $billingName ?: 'Guest',
                            'email' => $billingEmail,
                            'phone' => $billingPhone,
                            'address' => $order['billing']['address_1'] ?? null,

                            'billing_name' => $billingName,
                            'billing_phone' => $billingPhone,
                            'billing_address_line_1' => $order['billing']['address_1'] ?? null,
                            'billing_address_line_2' => $order['billing']['address_2'] ?? null,
                            'billing_address_line_3' => $order['billing']['state'] ?? null,
                            'billing_address_line_4' => $order['billing']['postcode'] ?? null,
                            'billing_country' => $order['billing']['country'] ?? null,
                            'billing_city' => $order['billing']['city'] ?? null,

                            'shipping_name' => $shippingName,
                            'shipping_phone' => $billingPhone,
                            'shipping_address_line_1' => $order['shipping']['address_1'] ?? null,
                            'shipping_address_line_2' => $order['shipping']['address_2'] ?? null,
                            'shipping_address_line_3' => $order['shipping']['state'] ?? null,
                            'shipping_address_line_4' => $order['shipping']['postcode'] ?? null,
                            'shipping_country' => $order['shipping']['country'] ?? null,
                            'shipping_city' => $order['shipping']['city'] ?? null,
                            'updated_at' => now(),
                        ];

                        if ($customer) {
                            DB::connection('tenant')
                                ->table('customers')
                                ->where('id', $customer->id)
                                ->update($customerData);

                            $customerId = $customer->id;
                        } else {
                            $customerId = DB::connection('tenant')
                                ->table('customers')
                                ->insertGetId(array_merge($customerData, [
                                    'status' => 1,
                                    'is_blacklisted' => 0,
                                    'opening_balance' => 0.00,
                                    'discount' => 0.00,
                                    'opening_balance_type' => 'receivable',
                                    'created_at' => now(),
                                ]));
                        }

                        $orderData = [
                            'customer_id' => $customerId,
                            'order_date' => $order['date_created'] ?? now(),
                            'order_status' => (($order['status'] ?? '') === 'completed') ? 1 : 0,
                            'total_products' => count($order['line_items'] ?? []),
                            'sub_total' => $order['total'] ?? 0,
                            'vat' => 0,
                            'total' => $order['total'] ?? 0,
                            'invoice_no' => $invoiceNo,
                            'payment_type' => $order['payment_method_title'] ?? 'WooCommerce',
                            'pay' => $order['total'] ?? 0,
                            'due' => 0,
                            'updated_at' => now(),
                        ];

                        if ($existingOrder) {
                            DB::connection('tenant')
                                ->table('orders')
                                ->where('id', $existingOrder->id)
                                ->update($orderData);

                            $orderId = $existingOrder->id;

                            DB::connection('tenant')
                                ->table('order_details')
                                ->where('order_id', $orderId)
                                ->delete();
                        } else {
                            $orderId = DB::connection('tenant')
                                ->table('orders')
                                ->insertGetId(array_merge($orderData, [
                                    'created_at' => now(),
                                ]));
                        }

                        foreach (($order['line_items'] ?? []) as $item) {
                            $wooProductId = $item['product_id'] ?? null;
                            $productName  = $item['name'] ?? 'Unknown Product';
                            $productSku   = $item['sku'] ?? null;

                            $localProduct = null;

                            if (!empty($wooProductId)) {
                                $localProduct = DB::connection('tenant')
                                    ->table('products')
                                    ->where('woocommerce_product_id', $wooProductId)
                                    ->first();
                            }

                            if (!$localProduct && !empty($wooProductId)) {
                                $localProduct = DB::connection('tenant')
                                    ->table('products')
                                    ->where('platform', 'woocommerce')
                                    ->where('platform_product_id', (string) $wooProductId)
                                    ->first();
                            }

                            if (!$localProduct && !empty($productName)) {
                                $localProduct = DB::connection('tenant')
                                    ->table('products')
                                    ->where('name', $productName)
                                    ->first();
                            }

                            DB::connection('tenant')
                                ->table('order_details')
                                ->insert([
                                    'order_id' => $orderId,
                                    'product_id' => $localProduct->id ?? null,
                                    'product_name' => $localProduct->name ?? $productName,
                                    'product_code' => $localProduct->code ?? $productSku,
                                    'woocommerce_product_id' => $wooProductId,
                                    'quantity' => $item['quantity'] ?? 1,
                                    'unitcost' => $item['price'] ?? 0,
                                    'total' => $item['total'] ?? 0,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                        }

                        DB::connection('tenant')->commit();
                    } catch (\Exception $orderError) {
                        DB::connection('tenant')->rollBack();

                        Log::error('Order sync failed', [
                            'woo_order_id' => $order['id'] ?? null,
                            'error' => $orderError->getMessage(),
                        ]);

                        continue;
                    }
                }
            } catch (\Exception $e) {
                Log::error('WooCommerce Order Sync Error: ' . $e->getMessage());

                return redirect()->route('orders.index')
                    ->with('error', $e->getMessage());
            }
        }

        return redirect()->route('orders.index')
            ->with('success', 'WooCommerce orders synced and stored in database successfully!');
    }

    public function generatePickList($orderId)
    {
        $user = auth()->user();
        $tenantDatabase = $user->tenant_db ?? 'tenantumico';
        config(['database.connections.tenant.database' => $tenantDatabase]);

        $order = DB::connection('tenant')
            ->table('orders')
            ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
            ->where('orders.id', $orderId)
            ->select(
                'orders.id',
                'orders.invoice_no',
                'orders.order_date',
                'orders.order_status',
                'orders.total_products',
                'orders.sub_total',
                'orders.vat',
                'orders.total',
                'orders.payment_type',
                'orders.pay',
                'orders.due',
                'orders.created_at',
                'customers.name as customer_name',
                'customers.email as customer_email',
                DB::raw('COALESCE(customers.billing_phone, customers.phone) as customer_phone'),
                DB::raw('COALESCE(customers.billing_city, customers.shipping_city) as customer_city'),
                DB::raw("TRIM(CONCAT_WS(', ',
                    customers.billing_address_line_1,
                    customers.billing_address_line_2,
                    customers.billing_address_line_3,
                    customers.billing_address_line_4
                )) as customer_address")
            )
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found!');
        }

        $orderDetails = DB::connection('tenant')
            ->table('order_details')
            ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
            ->where('order_details.order_id', $orderId)
            ->select(
                'order_details.id',
                'order_details.product_id',
                'order_details.product_name as order_product_name',
                'order_details.product_code as order_product_code',
                'order_details.quantity',
                'order_details.unitcost',
                'order_details.total',
                'products.name as product_name',
                'products.product_image',
                'products.code as product_code'
            )
            ->get();

        $totalQty = $orderDetails->sum('quantity');

        return view('orders.picklist', compact('order', 'orderDetails', 'totalQty'));
    }

    public function packingList($orderId)
    {
        $user = auth()->user();
        $tenantDatabase = $user->tenant_db ?? 'tenantumico';
        config(['database.connections.tenant.database' => $tenantDatabase]);

        $order = DB::connection('tenant')->table('orders')->where('id', $orderId)->first();

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found!');
        }

        $orderDetails = DB::connection('tenant')
            ->table('order_details')
            ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
            ->where('order_details.order_id', $orderId)
            ->select(
                'order_details.product_id',
                'order_details.product_name',
                'order_details.product_code',
                'products.name as product_name_from_products',
                'products.product_image',
                'order_details.quantity',
                'order_details.unitcost',
                'order_details.total'
            )
            ->get();

        return view('orders.packing-list', compact('order', 'orderDetails'));
    }

    public function generateInvoice($orderId)
    {
        $user = auth()->user();
        $tenantDatabase = $user->tenant_db ?? 'tenantumico';
        config(['database.connections.tenant.database' => $tenantDatabase]);

        $order = DB::connection('tenant')->table('orders')->where('id', $orderId)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found!');
        }

        $orderDetails = DB::connection('tenant')
            ->table('order_details')
            ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
            ->where('order_details.order_id', $orderId)
            ->select(
                'order_details.product_name',
                'order_details.product_code',
                'products.name as product_name_from_products',
                'products.product_image',
                'order_details.quantity',
                'order_details.unitcost',
                'order_details.total'
            )
            ->get();

        $pdf = Pdf::loadView('orders.invoice', compact('order', 'orderDetails'));

        return $pdf->stream('invoice-' . $order->invoice_no . '.pdf');
    }

    public function resyncSingleOrderDetails($orderId)
{
    $user = auth()->user();
    $tenantDatabase = $user->tenant_db ?? 'tenantumico';
    config(['database.connections.tenant.database' => $tenantDatabase]);

    $order = DB::connection('tenant')->table('orders')->where('id', $orderId)->first();

    if (!$order) {
        return redirect()->back()->with('error', 'Order not found.');
    }

    $integration = DB::connection('tenant')
        ->table('user_integrations')
        ->where('user_id', $user->id)
        ->where('platform', 'woocommerce')
        ->first();

    if (!$integration) {
        return redirect()->back()->with('error', 'WooCommerce integration not found.');
    }

    try {
        // INV-49537 => 49537
        $wooOrderId = (int) str_replace('INV-', '', $order->invoice_no);

        $storeUrl = rtrim($integration->store_url, '/');
        $apiUrl = $storeUrl . '/orders/' . $wooOrderId;

        $response = Http::timeout(60)->get($apiUrl, [
            'consumer_key' => $integration->api_key,
            'consumer_secret' => $integration->api_secret,
        ]);

        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Failed to fetch Woo order details.');
        }

        $wooOrder = $response->json();

        DB::connection('tenant')->beginTransaction();

        DB::connection('tenant')
            ->table('order_details')
            ->where('order_id', $orderId)
            ->delete();

        foreach (($wooOrder['line_items'] ?? []) as $item) {
            $wooProductId = $item['product_id'] ?? null;
            $productName  = $item['name'] ?? 'Unknown Product';
            $productSku   = $item['sku'] ?? null;

            $localProduct = null;

            if (!empty($wooProductId)) {
                $localProduct = DB::connection('tenant')
                    ->table('products')
                    ->where('woocommerce_product_id', $wooProductId)
                    ->first();
            }

            if (!$localProduct && !empty($wooProductId)) {
                $localProduct = DB::connection('tenant')
                    ->table('products')
                    ->where('platform', 'woocommerce')
                    ->where('platform_product_id', (string) $wooProductId)
                    ->first();
            }

            if (!$localProduct && !empty($productName)) {
                $localProduct = DB::connection('tenant')
                    ->table('products')
                    ->where('name', $productName)
                    ->first();
            }

            DB::connection('tenant')->table('order_details')->insert([
                'order_id' => $orderId,
                'product_id' => $localProduct->id ?? null,
                'product_name' => $localProduct->name ?? $productName,
                'product_code' => $localProduct->code ?? $productSku,
                'woocommerce_product_id' => $wooProductId,
                'quantity' => $item['quantity'] ?? 1,
                'unitcost' => $item['price'] ?? 0,
                'total' => $item['total'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::connection('tenant')
            ->table('orders')
            ->where('id', $orderId)
            ->update([
                'total_products' => count($wooOrder['line_items'] ?? []),
                'updated_at' => now(),
            ]);

        DB::connection('tenant')->commit();

        return redirect()->back()->with('success', 'Order items synced successfully.');
    } catch (\Exception $e) {
        DB::connection('tenant')->rollBack();
        return redirect()->back()->with('error', $e->getMessage());
    }
}

public function pickListIndex(Request $request)
{
    $user = auth()->user();
    $tenantDatabase = $user->tenant_db ?? 'tenantumico';
    config(['database.connections.tenant.database' => $tenantDatabase]);

    $query = DB::connection('tenant')
        ->table('orders')
        ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
        ->leftJoin('users as assigned_user', 'assigned_user.id', '=', 'orders.assigned_user_id')
        ->select(
            'orders.id',
            'orders.invoice_no',
            'orders.order_date',
            'orders.order_status',
            'orders.total_products',
            'orders.total',
            'orders.payment_type',
            'orders.pick_priority',
            'orders.pick_progress',
            'orders.assigned_user_id',
            'customers.name as customer_name',
            'customers.email as customer_email',
            'assigned_user.name as assigned_user_name',
            DB::raw('COALESCE(customers.billing_city, customers.shipping_city) as customer_city')
        );

    if ($request->status !== null && $request->status !== '') {
        if ($request->status === 'pending' || $request->status === '0') {
            $query->where('orders.order_status', 0);
        } elseif ($request->status === 'completed' || $request->status === '1') {
            $query->where('orders.order_status', 1);
        }
    }

    if ($request->priority) {
        $query->where('orders.pick_priority', $request->priority);
    }

    if ($request->progress !== null && $request->progress !== '') {
        if ($request->progress === 'not_started') {
            $query->where(function ($q) {
                $q->whereNull('orders.pick_progress')->orWhere('orders.pick_progress', 0);
            });
        } elseif ($request->progress === 'in_progress') {
            $query->whereBetween('orders.pick_progress', [1, 99]);
        } elseif ($request->progress === 'completed') {
            $query->where('orders.pick_progress', 100);
        }
    }

    if ($request->assigned_user_id) {
        $query->where('orders.assigned_user_id', $request->assigned_user_id);
    }

    if ($request->search) {
        $search = trim($request->search);
        $query->where(function ($q) use ($search) {
            $q->where('orders.invoice_no', 'like', "%{$search}%")
                ->orWhere('customers.name', 'like', "%{$search}%")
                ->orWhere('customers.email', 'like', "%{$search}%")
                ->orWhere('customers.billing_city', 'like', "%{$search}%")
                ->orWhere('customers.shipping_city', 'like', "%{$search}%");
        });
    }

    $orders = $query->orderByDesc('orders.id')->paginate(20)->withQueryString();

    $totalOrders = DB::connection('tenant')->table('orders')->count();
    $totalProducts = DB::connection('tenant')->table('orders')->sum('total_products');
    $ordersTotalValue = DB::connection('tenant')->table('orders')->sum('total');
    $averageOrderValue = $totalOrders > 0 ? $ordersTotalValue / $totalOrders : 0;
    $shippingTotal = 0;
    $averageShipping = 0;

    $users = DB::connection('tenant')
        ->table('users')
        ->select('id', 'name')
        ->orderBy('name')
        ->get();

    return view('orders.picklist-index', compact(
        'orders',
        'users',
        'totalOrders',
        'totalProducts',
        'ordersTotalValue',
        'averageOrderValue',
        'shippingTotal',
        'averageShipping'
    ));
}

public function updatePickPriority(Request $request, $orderId)
{
    $user = auth()->user();
    $tenantDatabase = $user->tenant_db ?? 'tenantumico';
    config(['database.connections.tenant.database' => $tenantDatabase]);

    $request->validate([
        'pick_priority' => 'nullable|in:Low,Medium,High,Urgent'
    ]);

    DB::connection('tenant')
        ->table('orders')
        ->where('id', $orderId)
        ->update([
            'pick_priority' => $request->pick_priority,
            'updated_at' => now(),
        ]);

    return redirect()->back()->with('success', 'Pick priority updated successfully.');
}

public function updatePickAssignedUser(Request $request, $orderId)
{
    $user = auth()->user();
    $tenantDatabase = $user->tenant_db ?? 'tenantumico';
    config(['database.connections.tenant.database' => $tenantDatabase]);

    $request->validate([
        'assigned_user_id' => 'nullable|integer'
    ]);

    DB::connection('tenant')
        ->table('orders')
        ->where('id', $orderId)
        ->update([
            'assigned_user_id' => $request->assigned_user_id ?: null,
            'updated_at' => now(),
        ]);

    return redirect()->back()->with('success', 'Assigned user updated successfully.');
}

public function updatePickProgress(Request $request, $orderId)
{
    $user = auth()->user();
    $tenantDatabase = $user->tenant_db ?? 'tenantumico';
    config(['database.connections.tenant.database' => $tenantDatabase]);

    $request->validate([
        'pick_progress' => 'required|integer|min:0|max:100'
    ]);

    DB::connection('tenant')
        ->table('orders')
        ->where('id', $orderId)
        ->update([
            'pick_progress' => $request->pick_progress,
            'updated_at' => now(),
        ]);

    return redirect()->back()->with('success', 'Pick progress updated successfully.');
}

// public function updatePickPriority(Request $request, $orderId)
// {
//     $user = auth()->user();
//     $tenantDatabase = $user->tenant_db ?? 'tenantumico';
//     config(['database.connections.tenant.database' => $tenantDatabase]);

//     $request->validate([
//         'pick_priority' => 'nullable|in:Low,Medium,High,Urgent'
//     ]);

//     DB::connection('tenant')
//         ->table('orders')
//         ->where('id', $orderId)
//         ->update([
//             'pick_priority' => $request->pick_priority,
//             'updated_at' => now(),
//         ]);

//     return redirect()->back()->with('success', 'Pick priority updated successfully.');
// }

// public function updatePickAssignedUser(Request $request, $orderId)
// {
//     $user = auth()->user();
//     $tenantDatabase = $user->tenant_db ?? 'tenantumico';
//     config(['database.connections.tenant.database' => $tenantDatabase]);

//     $request->validate([
//         'assigned_user_id' => 'nullable|integer'
//     ]);

//     DB::connection('tenant')
//         ->table('orders')
//         ->where('id', $orderId)
//         ->update([
//             'assigned_user_id' => $request->assigned_user_id ?: null,
//             'updated_at' => now(),
//         ]);

//     return redirect()->back()->with('success', 'Assigned user updated successfully.');
// }

}