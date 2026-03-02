<?php

namespace App\Livewire\Integrations;

use App\Models\UserIntegration;
use Livewire\Component;
use Livewire\WithPagination;

class IntegrationManager extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        UserIntegration::findOrFail($id)->delete();
        session()->flash('success', 'Integration deleted.');
    }

    public function render()
    {
        $integrations = UserIntegration::when($this->search, function ($query) {
            $query->where('platform', 'like', '%' . $this->search . '%')
                  ->orWhere('store_nickname', 'like', '%' . $this->search . '%')
                  ->orWhere('store_url', 'like', '%' . $this->search . '%');
        })->latest()->paginate(10);

        return view('livewire.integrations.integration-manager', compact('integrations'));
    }
}
