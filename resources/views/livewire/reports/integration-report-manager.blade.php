<div>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card" wire:ignore>
                <div class="card-body">
                    <h3 class="card-title">Integration Status Overview</h3>
                    <div id="chart-integrations" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>Platform</th>
                        <th>Store URL</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($integrations as $ui)
                    <tr>
                        <td class="font-weight-medium">{{ $ui->integration ? $ui->integration->name : 'Unknown' }}</td>
                        <td class="text-muted"><a href="{{ $ui->store_url }}" target="_blank">{{ $ui->store_url }}</a></td>
                        <td>
                            @if($ui->status === 'active')
                                <span class="badge bg-green-lt">Active</span>
                            @else
                                <span class="badge bg-red-lt">Disconnected</span>
                            @endif
                        </td>
                        <td>{{ $ui->updated_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">No integrations configured yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            let chart = new ApexCharts(document.querySelector("#chart-integrations"), {
                series: [{ name: "Active Status", data: @json($chartData['values']) }],
                chart: { type: 'bar', height: 300, toolbar: { show: false } },
                xaxis: { categories: @json($chartData['labels']) },
                colors: ['#206bc4'],
                plotOptions: {
                    bar: { borderRadius: 4, horizontal: true }
                }
            });
            chart.render();
        });
    </script>
</div>