<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WooIntegration;
use App\Services\WooCommerceClient;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class WooIntegrationController extends Controller
{
    // Show integration form
    public function create()
    {
        return view('woo_integrations.create');
    }

    // Save integration
    public function store(Request $request)
    {
        $data = $request->all();

        $booleanFields = [
            'push_fulfillment',
            'auto_import_orders',
            'update_price',
            'auto_import_products',
            'sync_stock',
            'update_product_on_import',
            'auto_generate_sku'
        ];

        foreach ($booleanFields as $field) {
            $data[$field] = $request->has($field) ? 1 : 0;
        }

        WooIntegration::create($data);

        return redirect()->back()->with('success', 'Integration Saved!');
    }

    // Sync Products
    public function syncProducts($id)
    {
        $integration = WooIntegration::findOrFail($id);
        $woo = new WooCommerceClient($integration->api_url, $integration->consumer_key, $integration->consumer_secret);

        try {
            $products = $woo->getProducts();

            foreach ($products as $product) {
                $sku = $product['sku'] ?? null;

                if ($integration->auto_generate_sku && empty($sku)) {
                    $sku = 'SKU-' . uniqid();
                }

                Product::updateOrCreate(
                    ['woocommerce_id' => $product['id']],
                    [
                        'name'  => $product['name'] ?? '',
                        'price' => (float)($product['price'] ?? 0),
                        'sku'   => $sku,
                        'stock' => (int)($product['stock_quantity'] ?? 0),
                    ]
                );

                // Optional: update WooCommerce stock from local DB if needed
                if ($integration->sync_stock) {
                    $woo->updateStock($product['id'], (int)($product['stock_quantity'] ?? 0));
                }
            }

            return redirect()->back()->with('success', 'Products Synced!');
        } catch (\Exception $e) {
            Log::error('WooCommerce syncProducts failed: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to sync products. Check logs.');
        }
    }

    // Sync Orders
    public function syncOrders($id)
    {
        $integration = WooIntegration::findOrFail($id);
        $woo = new WooCommerceClient($integration->api_url, $integration->consumer_key, $integration->consumer_secret);

        try {
            $orders = $woo->getOrders();

            foreach ($orders as $order) {
                Order::updateOrCreate(
                    ['woocommerce_id' => $order['id']],
                    [
                        'customer_name' => ($order['billing']['first_name'] ?? '') . ' ' . ($order['billing']['last_name'] ?? ''),
                        'total'         => (float)($order['total'] ?? 0),
                        'status'        => $order['status'] ?? '',
                    ]
                );
            }

            return redirect()->back()->with('success', 'Orders Synced!');
        } catch (\Exception $e) {
            Log::error('WooCommerce syncOrders failed: '.$e->getMessage());
            return redirect()->back()->with('error', 'Failed to sync orders. Check logs.');
        }
    }
}