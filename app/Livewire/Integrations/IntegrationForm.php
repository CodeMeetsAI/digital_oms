<?php

namespace App\Livewire\Integrations;

use App\Models\UserIntegration;
use App\Models\Integration;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Exception;

class IntegrationForm extends Component
{
    // Form fields
    public $integrationId;
    public $platform;
    public $store_nickname;
    public $store_url;
    public $api_key;
    public $secret_key;
    
    // UI Feedback States
    public $testStatus = null; // 'success' or 'error'
    public $testMessage = '';
    public $sampleProductCount = 0;
    public $currentStatus = 'disconnected';
    public $lastSync = null;

    protected $rules = [
        'store_url' => 'required|url',
        'api_key' => 'required|string',
        'platform' => 'required',
    ];

    public function mount($slug)
    {
        $integrationRecord = Integration::where('slug', $slug)->firstOrFail();
        $this->integrationId = $integrationRecord->id;
        $this->platform = $slug;

        // Load existing tenant settings
        $userInt = UserIntegration::where('integration_id', $this->integrationId)->first();
        if ($userInt) {
            $this->store_nickname = $userInt->store_nickname;
            $this->store_url = $userInt->store_url;
            $this->api_key = $userInt->api_key;
            $this->secret_key = $userInt->secret_key;
            $this->sampleProductCount = $userInt->sample_product_count ?? 0;
            $this->currentStatus = $userInt->status;
            $this->lastSync = $userInt->last_sync_at;
        }
    }

    /**
     * 1. Test Connection: Validate API credentials without saving to DB.
     */
    public function testConnection()
    {
        $this->validate();
        $this->testStatus = null;

        try {
            $response = $this->callApi();

            if ($response->successful()) {
                $this->testStatus = 'success';
                $this->testMessage = 'Live Connection Successful! API responded correctly.';
            } else {
                $this->testStatus = 'error';
                $this->testMessage = 'Connection Failed: HTTP ' . $response->status() . ' - ' . ($response->json('message') ?? 'Verify keys.');
            }
        } catch (Exception $e) {
            $this->testStatus = 'error';
            $this->testMessage = 'API Connection Error: ' . $e->getMessage();
        }
    }

    /**
     * 2. Save Connection: Save credentials to Tenant DB (status='pending').
     */
    public function saveConnection()
    {
        $this->validate();
        
        $userInt = UserIntegration::updateOrCreate(
            ['integration_id' => $this->integrationId],
            [
                'platform' => $this->platform,
                'store_nickname' => $this->store_nickname ?? ucfirst($this->platform),
                'store_url' => $this->store_url,
                'api_key' => $this->api_key,
                'secret_key' => $this->secret_key,
                'status' => 'pending',
            ]
        );

        $this->currentStatus = 'pending';
        session()->flash('success', 'Credentials saved locally as Pending.');
    }

    /**
     * 3. Connect Account: Verify API, Save to DB, Activate, and Fetch Stats.
     */
    public function connectAccount()
    {
        $this->validate();
        $this->testStatus = null;

        try {
            $response = $this->callApi();

            if ($response->successful()) {
                $data = $response->json();
                $count = $this->platform === 'shopify' ? count($data['products'] ?? []) : count($data);

                $userInt = UserIntegration::updateOrCreate(
                    ['integration_id' => $this->integrationId],
                    [
                        'platform' => $this->platform,
                        'store_nickname' => $this->store_nickname ?? ucfirst($this->platform),
                        'store_url' => $this->store_url,
                        'api_key' => $this->api_key,
                        'secret_key' => $this->secret_key,
                        'status' => 'connected',
                        'sample_product_count' => $count,
                        'last_sync_at' => now(),
                    ]
                );

                $this->sampleProductCount = $count;
                $this->currentStatus = 'connected';
                $this->lastSync = $userInt->last_sync_at;
                $this->testStatus = 'success';
                $this->testMessage = "Account Connected! Found $count products.";
            } else {
                $this->testStatus = 'error';
                $this->testMessage = 'Activation Failed: Platform rejected the connection.';
            }
        } catch (Exception $e) {
            $this->testStatus = 'error';
            $this->testMessage = 'Fatal Connection Error: ' . $e->getMessage();
        }
    }

    private function callApi()
    {
        $url = rtrim($this->store_url, '/');
        $timeout = 10;

        if ($this->platform === 'woocommerce') {
            return Http::withBasicAuth($this->api_key, $this->secret_key)
                ->timeout($timeout)->get("$url/wp-json/wc/v3/products?per_page=1");
        }

        if ($this->platform === 'shopify') {
            return Http::withHeaders(['X-Shopify-Access-Token' => $this->api_key])
                ->timeout($timeout)->get("$url/admin/api/2023-01/products.json?limit=1");
        }

        throw new Exception("Adapter missing for " . $this->platform);
    }

    public function render()
    {
        return view('livewire.integrations.integration-form');
    }
}
