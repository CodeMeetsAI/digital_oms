<?php

namespace App\Livewire\Tables;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerTable extends Component
{
    use WithPagination;

    protected $listeners = [
        'customer-created' => '$refresh',
    ];

    public $perPage = 10;

    public $search = '';

    public $searchType = 'id';

    public $sortField = 'id';

    public $sortAsc = false;

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;

        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $query = Customer::query()
            ->with(['category', 'orders'])
            ->withCount('orders')
            ->withSum('orders as total_sales', 'total')
            ->withSum('orders as total_due', 'due');

        if ($this->search) {
            if ($this->searchType === 'id') {
                $query->where('id', $this->search);
            } else {
                $query->where($this->searchType, 'like', '%'.$this->search.'%');
            }
        }

        return view('livewire.tables.customer-table', [
            'customers' => $query
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
