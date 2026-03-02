<?php

namespace App\Livewire\Reports;

use App\Models\Financial;
use Livewire\Component;
use Livewire\WithPagination;

class FinancialReportManager extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $financials = Financial::latest()->paginate(10);
        
        $revenue = Financial::where('type', 'revenue')->sum('amount');
        $expense = Financial::where('type', 'expense')->sum('amount');

        $chartData = [
            'labels' => ['Revenue', 'Expense'],
            'values' => [(float) $revenue, (float) $expense]
        ];

        return view('livewire.reports.financial-report-manager', [
            'financials' => $financials,
            'chartData' => $chartData
        ]);
    }
}
