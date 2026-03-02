<div>
    <div class="card mb-3">
        <div class="card-body">
            @if(session()->has('success'))
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

            <div class="row g-2 align-items-center">
                <div class="col">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search by platform or store name...">
                </div>
                <div class="col-auto">
                    <a href="{{ route('integrations.create') }}" class="btn btn-primary">Connect Store</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-deck row-cards">
        @forelse($integrations as $int)
        <div class="col-md-6 col-lg-4">
            <div class="card card-sm">
                <div class="card-status-top {{ $int->status == 'active' ? 'bg-green' : 'bg-red' }}"></div>
                <div class="card-body py-4 text-center">
                    <div class="mb-3">
                        @php $platforms = \App\Models\UserIntegration::supportedPlatforms(); @endphp
                        <img src="{{ $platforms[$int->platform]['icon_url'] ?? '' }}" alt="{{ $int->platform }}" style="height: 48px;">
                    </div>
                    <h3 class="card-title mb-1">{{ $int->store_nickname }}</h3>
                    <div class="text-muted small mb-3">Syncing from <strong>{{ ucfirst($int->platform) }}</strong></div>
                    <div class="small">Last Sync: <strong>{{ $int->last_sync_at ? $int->last_sync_at->diffForHumans() : 'Never' }}</strong></div>
                    <div class="mt-3">
                        <span class="badge {{ $int->status == 'active' ? 'bg-green-lt' : 'bg-red-lt' }}">
                            {{ ucfirst($int->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-light p-2 text-end">
                    <div class="btn-list flex-nowrap">
                        <a href="{{ route('integrations.edit', $int->id) }}" class="btn btn-ghost-primary btn-sm">Edit</a>
                        <button onclick="confirm('Disconnect this store? All synced data will remain in OMS.') || event.stopImmediatePropagation()" wire:click="delete({{ $int->id }})" class="btn btn-ghost-danger btn-sm">Disconnect</button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
             <div class="text-muted mb-3">No marketplace stores connected yet.</div>
             <a href="{{ route('integrations.create') }}" class="btn btn-primary">Get Started</a>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $integrations->links() }}
    </div>
</div>
