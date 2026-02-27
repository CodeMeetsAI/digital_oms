<?php

namespace App\Livewire\Tables;

use App\Models\Supplier;
use App\Models\SupplierCategory;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierTable extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $filterType = '';

    public $filterCategory = '';

    public $sortField = 'name';

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
        return view('livewire.tables.supplier-table', [
            'suppliers' => Supplier::query()
                ->with(['supplierCategory'])
                ->withCount('purchases')
                ->withSum('purchases', 'total_amount')
                ->when($this->filterType, function ($query) {
                    $query->where('type', $this->filterType);
                })
                ->when($this->filterCategory, function ($query) {
                    $query->where('supplier_category_id', $this->filterCategory);
                })
                ->search($this->search)
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
            'categories' => SupplierCategory::all(),
        ]);
    }
}
