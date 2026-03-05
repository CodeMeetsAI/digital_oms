<?php

namespace App\Services\Integrations;

use App\Models\UserIntegration;

interface IntegrationServiceInterface
{
    /**
     * Test the connection to the platform.
     * @return bool
     */
    public function testConnection(): bool;

    /**
     * Fetch products from the platform and save to OMS.
     * @return array Result summary
     */
    public function fetchProducts(): array;

    /**
     * Import orders from the platform and save to OMS.
     * @return array Result summary
     */
    public function importOrders(): array;

    /**
     * Sync local stock changes back to the platform.
     * @param string $platformProductId
     * @param int $quantity
     * @return bool
     */
    public function syncStock(string $platformProductId, int $quantity): bool;
}
