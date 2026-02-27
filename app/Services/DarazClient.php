<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DarazClient
{
    public function test(string $baseUrl, string $key, string $secret): array
    {
        $url = rtrim($baseUrl, '/').'/';
        $response = Http::withHeaders([
            'X-API-KEY' => $key,
            'X-API-SECRET' => $secret,
        ])->get($url);

        return [
            'ok' => $response->successful(),
            'status' => $response->status(),
            'body' => $response->json(),
        ];
    }
}
