<div>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card" wire:ignore>
                <div class="card-body">
                    <h3 class="card-title">Revenue vs Expenses</h3>
                    <div id="chart-financials" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($financials as $fin)
                    <tr>
                        <td>{{ $fin->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($fin->type == 'revenue')
                                <span class="badge bg-green-lt">Revenue</span>
                            @else
                                <span class="badge bg-red-lt">Expense</span>
                            @endif
                        </td>
                        <td class="text-end">${{ number_format($fin->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">No financial records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            {{ $financials->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            let chart = new ApexCharts(document.querySelector("#chart-financials"), {
                series: @json($chartData['values']),
                labels: @json($chartData['labels']),
                chart: { type: 'pie', height: 300 },
                colors: ['#2fb344', '#d63939'],
            });
            chart.render();
        });
    </script>
</div>