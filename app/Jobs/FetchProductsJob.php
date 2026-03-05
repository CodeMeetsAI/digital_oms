<?php

namespace App\Jobs;

use App\Models\UserIntegration;
use App\Services\Integrations\WooCommerceService;
use App\Services\Integrations\ShopifyService;
use App\Services\Integrations\DarazService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $integration;

    /**
     * Create a new job instance.
     */
    public function __construct(UserIntegration $integration)
    {
        $this->integration = $integration;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Must ensure we run in the correct tenant context if needed, 
        // but typically handled by tenant aware job dispatchers.

        if (!$this->integration->fetch_products) {
            return; // Permission disabled
        }

        $service = $this->getService();
        if ($service) {
            $result = $service->fetchProducts();
            
            if ($result['success']) {
                $this->integration->update([
                    'last_sync_at' => now(),
                    'sample_product_count' => $result['count'] ?? $this->integration->sample_product_count
                ]);
            } else {
                Log::error("FetchProductsJob Failed: " . $result['message']);
            }
        }
    }

    protected function getService()
    {
        switch ($this->integration->platform) {
            case 'woocommerce':
                return new WooCommerceService($this->integration);
            case 'shopify':
                return new ShopifyService($this->integration);
            case 'daraz':
                return new DarazService($this->integration);
            default:
                return null;
        }
    }
}
