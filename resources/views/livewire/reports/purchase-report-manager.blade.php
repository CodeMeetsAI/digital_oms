<div>
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">Filter Purchases</h3>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">From Date</label>
                    <input type="date" wire:model.live="fromDate" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">To Date</label>
                    <input type="date" wire:model.live="toDate" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Supplier</label>
                    <select wire:model.live="supplierId" class="form-select">
                        <option value="">All Suppliers</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card" wire:ignore>
                <div class="card-body">
                    <h3 class="card-title">Purchases Over Time</h3>
                    <div id="chart-purchases" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>Purchase No.</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->purchaseData as $purchase)
                    <tr>
                        <td>{{ $purchase->purchase_no ?? $purchase->id }}</td>
                        <td>{{ $purchase->supplier ? $purchase->supplier->name : 'N/A' }}</td>
                        <td>{{ $purchase->date ?? $purchase->created_at->format('Y-m-d') }}</td>
                        <td><span class="badge bg-secondary-lt">{{ ucfirst($purchase->status ?? 'Completed') }}</span></td>
                        <td class="text-end font-weight-bold">${{ number_format($purchase->total_amount ?? $purchase->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No purchases found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            {{ $this->purchaseData->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            let chart = new ApexCharts(document.querySelector("#chart-purchases"), {
                series: [{ name: "Purchases", data: @json($this->chartData['values']) }],
                chart: { type: 'bar', height: 300, toolbar: { show: false }, animations: { enabled: false } },
                xaxis: { categories: @json($this->chartData['labels']) },
                colors: ['#f59f00'],
            });
            chart.render();

            Livewire.on('refreshChart', (event) => {
                chart.updateSeries([{ data: event.data.values }]);
                chart.updateOptions({ xaxis: { categories: event.data.labels } });
            });
        });
    </script>
</div>