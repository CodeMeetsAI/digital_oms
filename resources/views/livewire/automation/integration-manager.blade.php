<div>
    <div class="row row-cards">
        <div class="col-12">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                        </div>
                        <div>{{ session('success') }}</div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Connect {{ $integration->name }}</h3>
                    <div class="card-actions">
                        <span class="badge {{ $status === 'active' ? 'bg-green' : 'bg-secondary' }}-lt">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="row row-cards">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Store URL</label>
                                    <input type="url" wire:model="store_url" class="form-control @error('store_url') is-invalid @enderror" placeholder="https://mystore.com">
                                    @error('store_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <small class="form-hint">The full base URL of your store (include https://).</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label required">API Key</label>
                                    <input type="text" wire:model="api_key" class="form-control @error('api_key') is-invalid @enderror">
                                    @error('api_key') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">API Secret</label>
                                    <input type="password" wire:model="api_secret" class="form-control @error('api_secret') is-invalid @enderror">
                                    @error('api_secret') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-between">
                            <button type="button" wire:click="test" wire:loading.attr="disabled" class="btn btn-outline-primary">
                                <span wire:loading wire:target="test" class="spinner-border spinner-border-sm me-2"></span>
                                Test Connection
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Connection
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Connection Status</h3>
                </div>
                <div class="card-body">
                    @if($testResult)
                        <div class="alert {{ $testResult['success'] ? 'alert-success' : 'alert-danger' }} mb-0">
                            <strong>{{ $testResult['success'] ? 'Online' : 'Offline' }}</strong>
                            <p class="small mb-0">{{ $testResult['message'] }}</p>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-muted mb-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><line x1="12" y1="16" x2="12.01" y2="16" /></svg>
                            <p class="text-muted">Test your connection to see current status.</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light small">
                    <ul class="mb-0">
                        <li>Sync Status: {{ $status }}</li>
                        <li>Sync Orders: <span class="badge bg-secondary">Inactive</span></li>
                        <li>Sync Products: <span class="badge bg-secondary">Inactive</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
