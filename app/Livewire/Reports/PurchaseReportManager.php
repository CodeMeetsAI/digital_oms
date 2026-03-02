<?php

namespace App\Livewire\Reports;

use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\Computed;

class PurchaseReportManager extends Component
{
    use WithPagination;

    public $fromDate;
    public $toDate;
    public $supplierId = '';
    
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->fromDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->toDate = Carbon::now()->format('Y-m-d');
    }

    #[Computed]
    public function purchaseData()
    {
        return Purchase::with('supplier')
            ->whereDate('date', '>=', $this->fromDate) // Note: assuming 'date' or 'created_at' based on standard. Use created_at if date not available.
            ->whereDate('date', '<=', $this->toDate)
            ->when($this->supplierId, fn($q) => $q->where('supplier_id', $this->supplierId))
            ->latest()
            ->paginate(10);
    }

    #[Computed]
    public function chartData()
    {
        $data = Purchase::whereDate('date', '>=', $this->fromDate)
            ->whereDate('date', '<=', $this->toDate)
            ->when($this->supplierId, fn($q) => $q->where('supplier_id', $this->supplierId))
            ->selectRaw('DATE(date) as date, SUM(total_amount) as total') // Assuming total_amount
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        return [
            'labels' => $data->keys()->toArray(),
            'values' => $data->values()->toArray(),
        ];
    }

    public function updated($property)
    {
        if (in_array($property, ['fromDate', 'toDate', 'supplierId'])) {
            $this->resetPage();
            $this->dispatch('refreshChart', data: $this->chartData);
        }
    }

    public function render()
    {
        return view('livewire.reports.purchase-report-manager', [
            'suppliers' => Supplier::all(),
        ]);
    }
}
