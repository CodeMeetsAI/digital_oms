<?php

namespace App\Livewire\Tables;

use App\Enums\PurchaseStatus;
use App\Enums\ShipmentStatus;
use App\Models\Purchase;
use Livewire\Component;
use Livewire\WithPagination;

class PurchaseTable extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $sortField = 'purchase_no';

    public $sortAsc = false;

    public $status = 'all';

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;

        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function render()
    {
        $query = Purchase::query()
            ->with(['supplier', 'createdBy'])
            ->search($this->search);

        // Apply Status Filter
        match ($this->status) {
            'cancelled' => $query->where('status', PurchaseStatus::CANCELLED),
            'completed' => $query->where('status', PurchaseStatus::COMPLETED),
            'fulfilled' => $query->where('shipment_status', ShipmentStatus::FULFILLED),
            'partially_fulfilled' => $query->where('shipment_status', ShipmentStatus::PARTIALLY_FULFILLED),
            'partially_returned' => $query->where('shipment_status', ShipmentStatus::PARTIALLY_RETURNED),
            'returned' => $query->where('shipment_status', ShipmentStatus::RETURNED),
            'unfulfilled' => $query->where('shipment_status', ShipmentStatus::UNFULFILLED),
            default => null,
        };

        return view('livewire.tables.purchase-table', [
            'purchases' => $query
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
            'counts' => $this->getStatusCounts(),
        ]);
    }

    public function getStatusCounts()
    {
        return [
            'all' => Purchase::count(),
            'cancelled' => Purchase::where('status', PurchaseStatus::CANCELLED)->count(),
            'completed' => Purchase::where('status', PurchaseStatus::COMPLETED)->count(),
            'fulfilled' => Purchase::where('shipment_status', ShipmentStatus::FULFILLED)->count(),
            'partially_fulfilled' => Purchase::where('shipment_status', ShipmentStatus::PARTIALLY_FULFILLED)->count(),
            'partially_returned' => Purchase::where('shipment_status', ShipmentStatus::PARTIALLY_RETURNED)->count(),
            'returned' => Purchase::where('shipment_status', ShipmentStatus::RETURNED)->count(),
            'unfulfilled' => Purchase::where('shipment_status', ShipmentStatus::UNFULFILLED)->count(),
        ];
    }
}
