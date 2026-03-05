<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Automattic\WooCommerce\Client;
use Illuminate\Support\Facades\DB;

class WooController extends Controller
{
    public function syncOrders()
    {
        // WooCommerce API client
        $woocommerce = new Client(
            'https://toysjedda.com',  // tumhara store URL
            'ck_xxxxx',               // consumer key
            'cs_xxxxx',               // consumer secret
            [
                'version' => 'wc/v3',
            ]
        );

        // Fetch orders (max 100 per page)
        $orders = $woocommerce->get('orders', ['per_page' => 100]);

        // Loop through orders and save to DB
        foreach ($orders as $order) {
            DB::table('orders')->updateOrInsert(
                ['order_id' => $order->id], // unique WooCommerce order ID
                [
                    'customer_name' => $order->billing->first_name . ' ' . $order->billing->last_name,
                    'customer_email' => $order->billing->email,
                    'total_amount' => $order->total,
                    'status' => $order->status,
                    'items' => json_encode($order->line_items)
                ]
            );
        }

        return "Orders synced successfully!";
    }
}