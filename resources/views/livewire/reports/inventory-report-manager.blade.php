<div>
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">Filter Inventory</h3>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <select wire:model.live="categoryId" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" wire:model.live="lowStockOnly">
                        <span class="form-check-label">Show Low Stock Only (< 10)</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card" wire:ignore>
                <div class="card-body">
                    <h3 class="card-title">Stock by Category</h3>
                    <div id="chart-inventory" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Quantity in Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->inventoryData as $product)
                    <tr>
                        <td class="text-muted">{{ $product->code ?? 'N/A' }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                        <td class="text-end">${{ number_format($product->selling_price ?? $product->price, 2) }}</td>
                        <td class="text-end">
                            @if($product->quantity < 10)
                                <span class="badge bg-red text-white">{{ $product->quantity }}</span>
                            @else
                                <span class="badge bg-green text-white">{{ $product->quantity }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            {{ $this->inventoryData->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            let chart = new ApexCharts(document.querySelector("#chart-inventory"), {
                series: @json($this->chartData['values']),
                labels: @json($this->chartData['labels']),
                chart: { type: 'donut', height: 300 },
                colors: ['#206bc4', '#4299e1', '#4ebbd5', '#17a2b8', '#0ca678'],
            });
            chart.render();
        });
    </script>
</div>