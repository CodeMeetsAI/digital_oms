<?php

namespace App\Services\Integrations;

use App\Models\UserIntegration;

class DarazService implements IntegrationServiceInterface
{
    protected $integration;

    public function __construct(UserIntegration $integration)
    {
        $this->integration = $integration;
    }

    public function testConnection(): bool
    {
        // Mock connection test
        return true;
    }

    public function fetchProducts(): array
    {
        return ['success' => true, 'message' => 'Daraz product fetch mocked.', 'count' => 0];
    }

    public function importOrders(): array
    {
        return ['success' => true, 'message' => 'Daraz order import mocked.', 'count' => 0];
    }

    public function syncStock(string $platformProductId, int $quantity): bool
    {
        return true;
    }
}
