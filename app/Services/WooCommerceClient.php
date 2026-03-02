<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WooCommerceClient
{
    protected string $baseUrl;
    protected string $key;
    protected string $secret;

    public function __construct(string $baseUrl, string $key, string $secret)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->key = $key;
        $this->secret = $secret;
    }

    // Test connection
    public function test(): array
    {
        $url = $this->baseUrl.'/wp-json/wc/v3/products?per_page=1';
        $response = Http::withBasicAuth($this->key, $this->secret)
            ->acceptJson()
            ->get($url);

        return [
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ];
    }

    // Get products (supports pagination)
    public function getProducts(int $perPage = 100, int $page = 1, array $filters = []): array
    {
        $query = array_merge(['per_page' => $perPage, 'page' => $page], $filters);
        $url = $this->baseUrl.'/wp-json/wc/v3/products';
        $response = Http::withBasicAuth($this->key, $this->secret)
            ->acceptJson()
            ->get($url, $query);

        if (!$response->successful()) {
            Log::error('WooCommerce getProducts failed', [
                'url' => $url,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        }

        return $response->json();
    }

    // Get orders (supports filters like status, after, before)
    public function getOrders(int $perPage = 50, int $page = 1, array $filters = []): array
    {
        $query = array_merge(['per_page' => $perPage, 'page' => $page], $filters);
        $url = $this->baseUrl.'/wp-json/wc/v3/orders';
        $response = Http::withBasicAuth($this->key, $this->secret)
            ->acceptJson()
            ->get($url, $query);

        if (!$response->successful()) {
            Log::error('WooCommerce getOrders failed', [
                'url' => $url,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        }

        return $response->json();
    }

    // Create a product
    public function createProduct(array $data): array
    {
        $url = $this->baseUrl.'/wp-json/wc/v3/products';
        $response = Http::withBasicAuth($this->key, $this->secret)
            ->acceptJson()
            ->post($url, $data);

        if (!$response->successful()) {
            Log::error('WooCommerce createProduct failed', [
                'url' => $url,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        }

        return $response->json();
    }

    // Update product (stock, price, etc.)
    public function updateProduct(int $productId, array $data): array
    {
        $url = $this->baseUrl."/wp-json/wc/v3/products/{$productId}";
        $response = Http::withBasicAuth($this->key, $this->secret)
            ->acceptJson()
            ->put($url, $data);

        if (!$response->successful()) {
            Log::error('WooCommerce updateProduct failed', [
                'url' => $url,
                'product_id' => $productId,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        }

        return $response->json();
    }

    // Update only stock quantity
    public function updateStock(int $productId, int $stock): array
    {
        return $this->updateProduct($productId, ['stock_quantity' => $stock]);
    }

    // Check if SKU exists
    public function checkSKU(string $sku): ?array
    {
        $products = $this->getProducts(1, 1, ['sku' => $sku]);
        return count($products) ? $products[0] : null;
    }
}