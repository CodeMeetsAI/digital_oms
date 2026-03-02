<?php

namespace App\Livewire\Reports;

use App\Models\Order;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\Computed;

class SalesReportManager extends Component
{
    use WithPagination;

    public $fromDate;
    public $toDate;
    public $customerId = '';
    public $status = '';
    
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->fromDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->toDate = Carbon::now()->format('Y-m-d');
    }

    #[Computed]
    public function salesData()
    {
        return Order::with('customer')
            ->whereDate('order_date', '>=', $this->fromDate)
            ->whereDate('order_date', '<=', $this->toDate)
            ->when($this->customerId, fn($q) => $q->where('customer_id', $this->customerId))
            ->when($this->status, fn($q) => $q->where('order_status', $this->status))
            ->latest()
            ->paginate(10);
    }

    #[Computed]
    public function chartData()
    {
        $data = Order::whereDate('order_date', '>=', $this->fromDate)
            ->whereDate('order_date', '<=', $this->toDate)
            ->when($this->customerId, fn($q) => $q->where('customer_id', $this->customerId))
            ->when($this->status, fn($q) => $q->where('order_status', $this->status))
            ->selectRaw('DATE(order_date) as date, SUM(total) as total')
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
        if (in_array($property, ['fromDate', 'toDate', 'customerId', 'status'])) {
            $this->resetPage();
            $this->dispatch('refreshChart', data: $this->chartData);
        }
    }

    public function exportCsv()
    {
        $fileName = 'sales_report_' . now()->format('Ymd') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Invoice', 'Customer', 'Date', 'Status', 'Total']);

            Order::with('customer')
                ->whereDate('order_date', '>=', $this->fromDate)
                ->whereDate('order_date', '<=', $this->toDate)
                ->when($this->customerId, fn($q) => $q->where('customer_id', $this->customerId))
                ->when($this->status, fn($q) => $q->where('order_status', $this->status))
                ->chunk(100, function($orders) use($file) {
                    foreach ($orders as $order) {
                        fputcsv($file, [
                            $order->invoice_no, 
                            $order->customer ? $order->customer->name : 'N/A', 
                            $order->order_date ? $order->order_date->format('Y-m-d') : '', 
                            $order->order_status, 
                            $order->total
                        ]);
                    }
                });
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        return view('livewire.reports.sales-report-manager', [
            'customers' => Customer::all(),
        ]);
    }
}
