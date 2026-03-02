<?php

namespace App\Livewire\Reports;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class InventoryReportManager extends Component
{
    use WithPagination;

    public $categoryId = '';
    public $lowStockOnly = false;
    
    protected $paginationTheme = 'bootstrap';

    #[Computed]
    public function inventoryData()
    {
        return Product::with('category')
            ->when($this->categoryId, fn($q) => $q->where('category_id', $this->categoryId))
            ->when($this->lowStockOnly, fn($q) => $q->where('quantity', '<', 10))
            ->orderBy('quantity', 'asc')
            ->paginate(15);
    }

    #[Computed]
    public function chartData()
    {
        $data = Product::with('category')
            ->selectRaw('category_id, SUM(quantity) as total_qty')
            ->groupBy('category_id')
            ->get();

        $labels = [];
        $values = [];

        foreach ($data as $item) {
            $labels[] = $item->category ? $item->category->name : 'Uncategorized';
            $values[] = (int) $item->total_qty;
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    public function updated($property)
    {
        if (in_array($property, ['categoryId', 'lowStockOnly'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.reports.inventory-report-manager', [
            'categories' => Category::all(),
        ]);
    }
}
