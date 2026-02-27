<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WooCommerceClient
{
    public function test(string $baseUrl, string $key, string $secret): array
    {
        $url = rtrim($baseUrl, '/').'/wp-json/wc/v3/products?per_page=1';
        $response = Http::withBasicAuth($key, $secret)->acceptJson()->get($url);

        return [
            'ok' => $response->successful(),
            'status' => $response->status(),
            'body' => $response->json(),
        ];
    }
}
