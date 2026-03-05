<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\UserIntegration; // Central DB model
use App\Models\Product;         // Tenant DB model
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Show all products page
     */
    public function index()
    {
        // Fetch products from tenant DB
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Sync products from connected WooCommerce integrations
     */
    public function sync(Request $request)
    {
        $user = Auth::user();

        try {
            // 🔹 Step 1: Fetch integrations from CENTRAL DB
            $integrations = \DB::connection('mysql') // central DB connection
                ->table('user_integrations')
                ->where('user_id', $user->id)
                ->where('platform', 'woocommerce')
                ->get();

            if ($integrations->isEmpty()) {
                return redirect()->route('products.index')
                    ->with('error', 'No WooCommerce integrations found for your account.');
            }

            // 🔹 Step 2: Run inside tenant context to insert/update products
            foreach ($integrations as $integration) {
                tenant()->run(function () use ($integration) {
                    $apiUrl = rtrim($integration->store_url, '/') . '/wp-json/wc/v3/products';
                    $apiKey = $integration->api_key;
                    $apiSecret = $integration->api_secret;

                    // WooCommerce API request
                    $response = Http::withBasicAuth($apiKey, $apiSecret)->get($apiUrl);

                    if (!$response->ok()) {
                        throw new \Exception("Failed to fetch products from store: {$integration->store_nickname}");
                    }

                    $productsData = $response->json();

                    foreach ($productsData as $p) {
                        Product::updateOrCreate(
                            [
                                'platform_product_id' => $p['id'],
                                'platform' => 'woocommerce',
                            ],
                            [
                                'name' => $p['name'],
                                'slug' => Str::slug($p['name']),
                                'selling_price' => $p['price'] ?? 0,
                                'quantity' => $p['stock_quantity'] ?? 0,
                                'product_image' => $p['images'][0]['src'] ?? null,
                            ]
                        );
                    }
                });
            }

            return redirect()->route('products.index')->with('success', 'Products synced successfully!');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Product sync failed: ' . $e->getMessage());
        }
    }
}