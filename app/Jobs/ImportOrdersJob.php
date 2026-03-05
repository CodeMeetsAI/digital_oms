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

class ImportOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $integration;

    public function __construct(UserIntegration $integration)
    {
        $this->integration = $integration;
    }

    public function handle(): void
    {
        if (!$this->integration->auto_import_orders) {
            return;
        }

        $service = $this->getService();
        if ($service) {
            $result = $service->importOrders();
            
            if ($result['success']) {
                $this->integration->update(['last_sync_at' => now()]);
            } else {
                Log::error("ImportOrdersJob Failed: " . $result['message']);
            }
        }
    }

    protected function getService()
    {
        switch ($this->integration->platform) {
            case 'woocommerce': return new WooCommerceService($this->integration);
            case 'shopify': return new ShopifyService($this->integration);
            case 'daraz': return new DarazService($this->integration);
            default: return null;
        }
    }
}
