<?php

namespace App\Livewire\Tables;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;

    public $perPage = 25;

    public $search = '';

    public $searchField = 'code';

    public $sortField = 'id';

    public $sortAsc = false;

    public $status = 'all';

    protected $listeners = ['productSearchUpdated', 'productSearchFieldUpdated'];

    public function mount()
    {
        $this->status = request()->query('status', $this->status);
    }

    public function productSearchUpdated($value): void
    {
        $this->search = $value;
        $this->resetPage();
    }

    public function productSearchFieldUpdated($value): void
    {
        $this->searchField = $value;
        $this->resetPage();
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

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
        $query = Product::query()
            ->with(['category', 'unit', 'simpleInventory', 'bundle']);

        if ($this->search !== '') {
            if ($this->searchField === 'name') {
                $query->where('name', 'like', "%{$this->search}%");
            } elseif ($this->searchField === 'barcode') {
                $query->whereHas('simpleInventory', function ($subQuery) {
                    $subQuery->where('barcode', 'like', "%{$this->search}%");
                });
            } elseif ($this->searchField === 'external_mapping_id') {
                $query->whereHas('simpleInventory', function ($subQuery) {
                    $subQuery->where('hs_code', 'like', "%{$this->search}%");
                });
            } elseif ($this->searchField === 'code') {
                $query->where('code', 'like', "%{$this->search}%");
            } else {
                $query->search($this->search);
            }
        }

        // Clone query for counts if we want search-dependent counts,
        // but typically tabs are top-level filters.
        // Let's use global counts for tabs as per typical design,
        // or maybe search should apply?
        // Let's use global counts for now to match "All (0)" style which usually implies total database records.

        $countAll = Product::count();
        $countInStock = Product::where('quantity', '>', 0)->count();
        $countOutOfStock = Product::where('quantity', 0)->count();
        $countLowStock = Product::whereColumn('quantity', '<=', 'quantity_alert')->count();
        $countServices = Product::whereHas('simpleInventory', function ($query) {
            $query->where('product_type', 'service');
        })->count();

        if ($this->status === 'in_stock') {
            $query->where('quantity', '>', 0);
        } elseif ($this->status === 'out_of_stock') {
            $query->where('quantity', 0);
        } elseif ($this->status === 'low_stock') {
            $query->whereColumn('quantity', '<=', 'quantity_alert');
        } elseif ($this->status === 'services') {
            $query->whereHas('simpleInventory', function ($query) {
                $query->where('product_type', 'service');
            });
        }

        $products = $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.tables.product-table', [
            'products' => $products,
            'countAll' => $countAll,
            'countInStock' => $countInStock,
            'countOutOfStock' => $countOutOfStock,
            'countLowStock' => $countLowStock,
            'countServices' => $countServices,
        ]);
    }
}
