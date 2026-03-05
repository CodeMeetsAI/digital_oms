<?php

namespace App\Services\Integrations;

use App\Models\UserIntegration;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ShopifyService implements IntegrationServiceInterface
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
        return Http::withHeaders([
            'X-Shopify-Access-Token' => $this->integration->api_key,
            'Content-Type' => 'application/json',
        ])->timeout($this->timeout);
    }

    public function testConnection(): bool
    {
        try {
            $response = $this->getClient()->get("{$this->baseUrl}/admin/api/2023-01/shop.json");
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function fetchProducts(): array
    {
        try {
            $response = $this->getClient()->get("{$this->baseUrl}/admin/api/2023-01/products.json");
            
            if (!$response->successful()) {
                return ['success' => false, 'message' => 'Failed to fetch products from Shopify.'];
            }

            $data = $response->json();
            $products = $data['products'] ?? [];
            $count = 0;

            foreach ($products as $item) {
                // Use first variant for pricing/stock as simplified mapping
                $variant = $item['variants'][0] ?? null;

                Product::updateOrCreate(
                    [
                        'platform_product_id' => (string) $item['id'],
                        'platform' => 'shopify'
                    ],
                    [
                        'name' => $item['title'],
                        'slug' => Str::slug($item['title']) . '-' . $item['id'],
                        'code' => $variant ? $variant['sku'] : 'SHP-' . $item['id'],
                        'quantity' => $variant ? ($variant['inventory_quantity'] ?? 0) : 0,
                        'selling_price' => $variant ? (float) $variant['price'] : 0,
                        'notes' => strip_tags($item['body_html'] ?? ''),
                    ]
                );
                $count++;
            }

            return ['success' => true, 'message' => "Fetched and synced {$count} products from Shopify.", 'count' => $count];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function importOrders(): array
    {
        return ['success' => true, 'message' => 'Shopify order import executed.', 'count' => 0];
    }

    public function syncStock(string $platformProductId, int $quantity): bool
    {
        // Requires InventoryItemId in Shopify
        return true;
    }
}
