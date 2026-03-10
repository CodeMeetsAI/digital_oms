<?php

namespace App\Livewire\Tables;

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderTable extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $status = 'all';

    public $sortField = 'invoice_no';

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

    public function setStatus($status): void
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function render()
    {
        $query = Order::with(['customer', 'details'])
            ->when($this->search, function ($q) {
                $q->where('invoice_no', 'like', "%{$this->search}%")
                  ->orWhereHas('customer', function ($q2) {
                      $q2->where('name', 'like', "%{$this->search}%");
                  });
            });

        match ($this->status) {
            'pending' => $query->where('order_status', OrderStatus::PENDING),
            'delivered' => $query->where('order_status', OrderStatus::COMPLETE),
            'void' => $query->where('order_status', OrderStatus::CANCEL),
            'ready_to_ship', 'booked', 'shipped', 'returned', 'delivery_failed', 'restocked' => $query->whereRaw('1=0'),
            default => null,
        };

        return view('livewire.tables.order-table', [
            'orders' => $query
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
            'counts' => $this->getStatusCounts(),
        ]);
    }

    private function getStatusCounts(): array
    {
        return [
            'all' => Order::count(),
            'ready_to_ship' => 0,
            'pending' => Order::where('order_status', OrderStatus::PENDING)->count(),
            'booked' => 0,
            'shipped' => 0,
            'delivered' => Order::where('order_status', OrderStatus::COMPLETE)->count(),
            'returned' => 0,
            'void' => Order::where('order_status', OrderStatus::CANCEL)->count(),
            'delivery_failed' => 0,
            'restocked' => 0,
        ];
    }
}