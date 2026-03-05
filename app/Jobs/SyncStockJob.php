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

class SyncStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $integration;
    protected $platformProductId;
    protected $quantity;

    public function __construct(UserIntegration $integration, string $platformProductId, int $quantity)
    {
        $this->integration = $integration;
        $this->platformProductId = $platformProductId;
        $this->quantity = $quantity;
    }

    public function handle(): void
    {
        if (!$this->integration->sync_stock) {
            return;
        }

        $service = clone $this->getService();
        if ($service) {
            $service->syncStock($this->platformProductId, $this->quantity);
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
