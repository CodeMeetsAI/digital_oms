<div class="row row-cards">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ ucfirst($platform) }} Integration</h3></div>
            <div class="card-body">
                <form wire:submit.prevent="connectAccount">
                    <div class="mb-3">
                        <label class="form-label required">Store / API Base URL</label>
                        <input type="url" wire:model.live="store_url" class="form-control @error('store_url') is-invalid @enderror" placeholder="https://yourstore.com">
                        @error('store_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">
                            {{ $platform === 'shopify' ? 'Admin Access Token' : 'Consumer Key (API Key)' }}
                        </label>
                        <input type="text" wire:model.live="api_key" class="form-control @error('api_key') is-invalid @enderror">
                        @error('api_key') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    @if($platform !== 'shopify')
                    <div class="mb-3">
                        <label class="form-label required">Consumer Secret (API Secret)</label>
                        <input type="password" wire:model.live="secret_key" class="form-control @error('secret_key') is-invalid @enderror">
                        @error('secret_key') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    @endif

                    <!-- Status Alerts -->
                    @if (session()->has('success'))
                        <div class="alert alert-success mt-3 border-0">{{ session('success') }}</div>
                    @endif

                    @if($testStatus)
                        <div class="alert {{ $testStatus == 'success' ? 'alert-success' : 'alert-danger' }} mt-3 border-0">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    @if($testStatus == 'success')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>
                                    @endif
                                </div>
                                <div class="fw-bold">{{ $testMessage }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="card-footer mt-4 p-0 pt-3 border-top d-flex justify-content-between flex-wrap gap-2">
                        <div class="btn-list">
                            <button type="button" wire:click="testConnection" wire:loading.attr="disabled" class="btn btn-outline-info">
                                <span wire:loading wire:target="testConnection" class="spinner-border spinner-border-sm me-2"></span>
                                Test Connection
                            </button>
                            <button type="button" wire:click="saveConnection" wire:loading.attr="disabled" class="btn btn-outline-secondary">
                                <span wire:loading wire:target="saveConnection" class="spinner-border spinner-border-sm me-2"></span>
                                Save Credentials
                            </button>
                        </div>
                        
                        <button type="button" wire:click="connectAccount" wire:loading.attr="disabled" class="btn btn-primary fw-bold">
                            <span wire:loading wire:target="connectAccount" class="spinner-border spinner-border-sm me-2"></span>
                            Connect Account
                        </button>
                    </div>

                    @if($platform === 'woocommerce')
                    <div class="mt-4 pt-4 border-top">
                        <div class="text-center">
                            <p class="text-muted small mb-3">Or connect automatically without manual keys</p>
                            <a href="{{ route('automation.integrations.woocommerce.connect', ['store_url' => $store_url]) }}" 
                               class="btn btn-dark w-100 py-2 d-flex align-items-center justify-content-center"
                               onclick="if(!document.querySelector('input[type=url]').value) { alert('Please enter your Store / API Base URL first'); return false; } this.href += '?store_url=' + encodeURIComponent(document.querySelector('input[type=url]').value);">
                                <img src="https://img.icons8.com/color/24/000000/woocommerce.png" class="me-2" alt="">
                                Connect via WooCommerce OAuth
                            </a>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header"><h3 class="card-title">Connection Summary</h3></div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="text-muted small uppercase fw-bold mb-1">Status</div>
                    <span class="badge {{ $currentStatus == 'connected' ? 'bg-green-lt' : ($currentStatus == 'pending' ? 'bg-yellow-lt' : 'bg-red-lt') }} p-2">
                        {{ ucfirst($currentStatus) }}
                    </span>
                </div>
                <div class="mb-3">
                    <div class="text-muted small uppercase fw-bold mb-1">Last Sync</div>
                    <div class="h4 mb-0">{{ $lastSync ? \Carbon\Carbon::parse($lastSync)->diffForHumans() : 'Never' }}</div>
                </div>
                <div class="mb-0">
                    <div class="text-muted small uppercase fw-bold mb-1">Sample Catalog</div>
                    <div class="h4 mb-0">{{ $sampleProductCount }} Products Identified</div>
                </div>
            </div>
            <div class="card-footer bg-light small text-muted italic">
                Active connection required for automated order pulls.
            </div>
        </div>
    </div>
</div>
