<?php

namespace App\Livewire\Financials;

use App\Models\ChartOfAccount;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ChartOfAccounts extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 10;

    public $filterStatus = 'all';

    public $filterName = '';

    public $filterType = '';

    public $minBalance = '';

    public $maxBalance = '';

    protected $paginationTheme = 'bootstrap';

    #[On('account-saved')]
    public function refresh()
    {
        // Refresh component
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function setFilterStatus($status)
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->filterName = '';
        $this->filterType = '';
        $this->minBalance = '';
        $this->maxBalance = '';
        $this->resetPage();
    }

    public function getActiveFiltersCountProperty()
    {
        $count = 0;
        if ($this->filterName) {
            $count++;
        }
        if ($this->filterType) {
            $count++;
        }
        if ($this->minBalance) {
            $count++;
        }
        if ($this->maxBalance) {
            $count++;
        }

        return $count;
    }

    public function render()
    {
        $query = ChartOfAccount::search($this->search);

        if ($this->filterStatus === 'active') {
            $query->where('status', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('status', false);
        }

        if ($this->filterName !== '') {
            $query->where('name', 'like', '%'.$this->filterName.'%');
        }
        if ($this->filterType !== '') {
            $query->where('type', $this->filterType);
        }
        if ($this->minBalance !== '' && $this->minBalance !== null) {
            $query->where('balance', '>=', $this->minBalance);
        }
        if ($this->maxBalance !== '' && $this->maxBalance !== null) {
            $query->where('balance', '<=', $this->maxBalance);
        }

        $accounts = $query->paginate($this->perPage);

        return view('livewire.financials.chart-of-accounts', [
            'accounts' => $accounts,
        ]);
    }
}
