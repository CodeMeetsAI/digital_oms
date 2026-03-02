<div>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card" wire:ignore>
                <div class="card-body">
                    <h3 class="card-title">Return Reasons</h3>
                    <div id="chart-returns" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Product</th>
                        <th>Reason</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returns as $ret)
                    <tr>
                        <td>{{ $ret->order ? $ret->order->invoice_no : 'N/A' }}</td>
                        <td>{{ $ret->product ? $ret->product->name : 'N/A' }}</td>
                        <td><span class="badge bg-secondary-lt">{{ $ret->reason }}</span></td>
                        <td>{{ $ret->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">No returns recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            {{ $returns->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            let chart = new ApexCharts(document.querySelector("#chart-returns"), {
                series: [{ name: "Returns", data: @json($chartData['values']) }],
                chart: { type: 'bar', height: 300, toolbar: { show: false } },
                xaxis: { categories: @json($chartData['labels']) },
                colors: ['#f66d9b'],
            });
            chart.render();
        });
    </script>
</div>