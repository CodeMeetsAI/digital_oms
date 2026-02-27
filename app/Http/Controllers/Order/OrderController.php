<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();

        return view('orders.index', [
            'orders' => $orders,
            'customers' => Customer::all(['id', 'name']),
            'users' => User::all(['id', 'name']),
            'productCategories' => Category::all(['id', 'name']),
            'productUnits' => Unit::all(['id', 'name']),
        ]);
    }

    public function create()
    {
        Cart::instance('order')
            ->destroy();

        return view('orders.create', [
            'carts' => Cart::content(),
            'customers' => Customer::all(['id', 'name']),
            'products' => Product::with(['category', 'unit'])->get(),
        ]);
    }

    public function store(OrderStoreRequest $request)
    {
        $items = $request->validated()['items'] ?? [];
        $discountPercentage = (float) $request->input('discount_percentage', 0);
        $shippingCharges = (float) $request->input('shipping_charges', 0);
        $tax = (float) $request->input('tax', 0);

        $grossTotal = 0;
        $lineDiscounts = 0;
        $totalQuantity = 0;

        foreach ($items as $item) {
            $qty = (float) $item['quantity'];
            $price = (float) $item['unit_price'];
            $discountPercent = (float) ($item['discount_percent'] ?? 0);
            $lineTotal = $price * $qty;
            $discountAmount = $lineTotal * ($discountPercent / 100);

            $grossTotal += $lineTotal;
            $lineDiscounts += $discountAmount;
            $totalQuantity += $qty;
        }

        $globalDiscount = $grossTotal * ($discountPercentage / 100);
        $totalDiscount = $lineDiscounts + $globalDiscount;
        $subTotal = $grossTotal - $lineDiscounts;
        $netTotal = $grossTotal - $totalDiscount + $tax + $shippingCharges;
        $pay = (float) $request->input('pay', 0);

        $order = Order::create([
            'customer_id' => $request->input('customer_id'),
            'order_date' => $request->input('order_date'),
            'order_status' => $request->input('order_status'),
            'total_products' => $totalQuantity,
            'sub_total' => $subTotal,
            'vat' => $tax,
            'total' => $netTotal,
            'invoice_no' => $request->input('invoice_no'),
            'payment_type' => $request->input('payment_type'),
            'pay' => $pay,
            'due' => $netTotal - $pay,
        ]);

        $details = [];
        foreach ($items as $item) {
            $details[] = [
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unitcost' => $item['unit_price'],
                'total' => $item['sub_total'],
                'created_at' => Carbon::now(),
            ];
        }

        if ($details) {
            OrderDetails::insert($details);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'order' => $order,
            ]);
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order has been created!');
    }

    public function show(Order $order)
    {
        $order->loadMissing(['customer', 'details'])->get();

        return view('orders.show', [
            'order' => $order,
        ]);
    }

    public function update(Order $order, Request $request)
    {
        // TODO refactoring

        // Reduce the stock
        $products = OrderDetails::where('order_id', $order)->get();

        foreach ($products as $product) {
            Product::where('id', $product->product_id)
                ->update(['quantity' => DB::raw('quantity-'.$product->quantity)]);
        }

        $order->update([
            'order_status' => OrderStatus::COMPLETE,
        ]);

        return redirect()
            ->route('orders.complete')
            ->with('success', 'Order has been completed!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
    }

    public function downloadInvoice($order)
    {
        $order = Order::with(['customer', 'details'])
            ->where('id', $order)
            ->first();

        return view('orders.print-invoice', [
            'order' => $order,
        ]);
    }
}
