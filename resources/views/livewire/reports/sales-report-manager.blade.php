<div>
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">Filter Sales</h3>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date" wire:model.live="fromDate" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date" wire:model.live="toDate" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Customer</label>
                    <select wire:model.live="customerId" class="form-select">
                        <option value="">All Customers</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select wire:model.live="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="complete">Complete</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-12 mt-3 text-end">
                    <button wire:click="exportCsv" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><polyline points="7 11 12 16 17 11" /><line x1="12" y1="4" x2="12" y2="16" /></svg>
                        Export CSV
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card" wire:ignore>
                <div class="card-body">
                    <h3 class="card-title">Sales Over Time</h3>
                    <div id="chart-sales" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->salesData as $order)
                    <tr>
                        <td>{{ $order->invoice_no }}</td>
                        <td>{{ $order->customer ? $order->customer->name : 'N/A' }}</td>
                        <td>{{ $order->order_date ? $order->order_date->format('Y-m-d') : '' }}</td>
                        <td>
                            @if($order->order_status == 'complete')
                                <span class="badge bg-green-lt">Complete</span>
                            @elseif($order->order_status == 'pending')
                                <span class="badge bg-yellow-lt">Pending</span>
                            @else
                                <span class="badge bg-secondary-lt">{{ ucfirst($order->order_status) }}</span>
                            @endif
                        </td>
                        <td class="text-end font-weight-bold">${{ number_format($order->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No sales found for the selected filters.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            {{ $this->salesData->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            let chart = new ApexCharts(document.querySelector("#chart-sales"), {
                series: [{ name: "Sales ($)", data: @json($this->chartData['values']) }],
                chart: { type: 'area', height: 300, toolbar: { show: false }, animations: { enabled: false } },
                xaxis: { categories: @json($this->chartData['labels']) },
                colors: ['#206bc4'],
                stroke: { width: 2, curve: 'smooth' },
                fill: { opacity: 0.16 }
            });
            chart.render();

            Livewire.on('refreshChart', (event) => {
                chart.updateSeries([{ data: event.data.values }]);
                chart.updateOptions({ xaxis: { categories: event.data.labels } });
            });
        });
    </script>
</div>