<?php

namespace App\Livewire\Reports;

use App\Models\ReturnManagement;
use Livewire\Component;
use Livewire\WithPagination;

class ReturnReportManager extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $returns = ReturnManagement::with(['order', 'product'])->latest()->paginate(10);
        
        $reasons = ReturnManagement::selectRaw('reason, COUNT(*) as count')
            ->groupBy('reason')
            ->get();

        $chartLabels = [];
        $chartValues = [];

        foreach ($reasons as $r) {
            $chartLabels[] = $r->reason;
            $chartValues[] = (int) $r->count;
        }

        $chartData = [
            'labels' => $chartLabels,
            'values' => $chartValues
        ];

        return view('livewire.reports.return-report-manager', [
            'returns' => $returns,
            'chartData' => $chartData
        ]);
    }
}
