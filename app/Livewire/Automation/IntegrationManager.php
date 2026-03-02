<?php

namespace App\Livewire\Automation;

use App\Models\Integration;
use App\Models\UserIntegration;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class IntegrationManager extends Component
{
    public $integration;
    public $store_url;
    public $api_key;
    public $api_secret;
    public $status = 'disconnected';
    public $testResult = null;

    protected $rules = [
        'store_url' => 'required|url',
        'api_key' => 'required|string',
        'api_secret' => 'nullable|string',
    ];

    public function mount($integrationSlug)
    {
        $this->integration = Integration::firstOrCreate(
            ['slug' => $integrationSlug],
            ['name' => ucfirst($integrationSlug)]
        );

        $userInt = UserIntegration::where('integration_id', $this->integration->id)->first();
        if ($userInt) {
            $this->store_url = $userInt->store_url;
            $this->api_key = $userInt->api_key;
            $this->api_secret = $userInt->api_secret;
            $this->status = $userInt->status;
        }
    }

    public function save()
    {
        $this->validate();

        UserIntegration::updateOrCreate(
            ['integration_id' => $this->integration->id],
            [
                'store_url' => $this->store_url,
                'api_key' => $this->api_key,
                'api_secret' => $this->api_secret,
                'status' => 'active',
            ]
        );

        $this->status = 'active';
        session()->flash('success', 'Integration settings saved.');
    }

    public function test()
    {
        $this->validate();
        
        $this->testResult = ['loading' => true];

        try {
            $response = Http::timeout(5)->get($this->store_url);
            
            if ($response->successful()) {
                $this->testResult = [
                    'success' => true,
                    'message' => 'Connection successful! (HTTP ' . $response->status() . ')'
                ];
            } else {
                $this->testResult = [
                    'success' => false,
                    'message' => 'Connection failed. HTTP Status: ' . $response->status()
                ];
            }
        } catch (\Exception $e) {
            $this->testResult = [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function render()
    {
        return view('livewire.automation.integration-manager');
    }
}
