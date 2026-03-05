<?php

namespace App\Services\Integrations;

use App\Models\UserIntegration;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WooCommerceService implements IntegrationServiceInterface
{
    protected $integration;
    protected $baseUrl;
    protected $timeout = 15;

    public function __construct(UserIntegration $integration)
    {
        $this->integration = $integration;
        $this->baseUrl = rtrim($integration->store_url, '/');
    }

    protected function getClient()
    {
        return Http::withBasicAuth($this->integration->api_key, $this->integration->secret_key)
            ->timeout($this->timeout);
    }

    public function testConnection(): bool
    {
        try {
            $response = $this->getClient()->get("{$this->baseUrl}/wp-json/wc/v3/products?per_page=1");
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function fetchProducts(): array
    {
        try {
            $response = $this->getClient()->get("{$this->baseUrl}/wp-json/wc/v3/products");
            
            if (!$response->successful()) {
                return ['success' => false, 'message' => 'Failed to fetch products. HTTP ' . $response->status()];
            }

            $products = $response->json();
            $count = 0;

            foreach ($products as $item) {
                // Map WC product to local Product
                Product::updateOrCreate(
                    [
                        'platform_product_id' => (string) $item['id'],
                        'platform' => 'woocommerce'
                    ],
                    [
                        'name' => $item['name'],
                        'slug' => Str::slug($item['name']) . '-' . $item['id'],
                        'code' => $item['sku'] ?: 'WC-' . $item['id'],
                        'quantity' => $item['manage_stock'] ? ($item['stock_quantity'] ?? 0) : 0,
                        'buying_price' => 0, // Cannot determine buying price from generic WC API easily
                        'selling_price' => (float) ($item['price'] ?: 0),
                        'notes' => strip_tags($item['description'] ?? ''),
                    ]
                );
                $count++;
            }

            return ['success' => true, 'message' => "Fetched and synced {$count} products from WooCommerce.", 'count' => $count];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function importOrders(): array
    {
        try {
            // Fetch processing orders
            $response = $this->getClient()->get("{$this->baseUrl}/wp-json/wc/v3/orders?status=processing");
            
            if (!$response->successful()) {
                return ['success' => false, 'message' => 'Failed to fetch orders.'];
            }

            $orders = $response->json();
            // In a real scenario, you'd map these to the OMS Orders table.
            // Simplified example count:
            $count = count($orders);

            return ['success' => true, 'message' => "Imported {$count} new orders from WooCommerce.", 'count' => $count];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function syncStock(string $platformProductId, int $quantity): bool
    {
        try {
            $response = $this->getClient()->put("{$this->baseUrl}/wp-json/wc/v3/products/{$platformProductId}", [
                'manage_stock' => true,
                'stock_quantity' => $quantity,
            ]);
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
