<?php

namespace App\Livewire\Automation;

use App\Models\ApiKey;
use Livewire\Component;
use Illuminate\Support\Str;

class ApiKeysManager extends Component
{
    public $name;
    public $newKey = null;

    protected $rules = [
        'name' => 'required|min:3|max:255',
    ];

    public function generate()
    {
        $this->validate();

        $key = 'oms_' . Str::random(40);
        
        ApiKey::create([
            'name' => $this->name,
            'api_key' => $key,
            'tenant_id' => tenant('id'),
        ]);

        $this->newKey = $key;
        $this->name = '';
        
        session()->flash('success', 'API Key generated successfully.');
    }

    public function revoke($id)
    {
        ApiKey::findOrFail($id)->delete();
        session()->flash('success', 'API Key revoked.');
    }

    public function render()
    {
        return view('livewire.automation.api-keys-manager', [
            'apiKeys' => ApiKey::latest()->get()
        ]);
    }
}
