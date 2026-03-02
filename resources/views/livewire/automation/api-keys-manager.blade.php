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

            @if($newKey)
                <div class="alert alert-important alert-warning" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01m-6.938 2.99a9 9 0 1 1 13.876 0a9 9 0 0 1 -13.876 0" /></svg>
                        </div>
                        <div>
                            <strong>Copy your new API key now.</strong> You won't be able to see it again!
                            <div class="mt-2">
                                <code class="bg-white p-2 d-block border rounded">{{ $newKey }}</code>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Generate New Key</h3>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="generate">
                        <div class="mb-3">
                            <label class="form-label">Key Name</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Mobile App, Zapier">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Generate Key
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Active API Keys</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Key Prefix</th>
                                <th>Created</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($apiKeys as $key)
                                <tr>
                                    <td>
                                        <div class="font-weight-medium">{{ $key->name }}</div>
                                    </td>
                                    <td class="text-muted">
                                        <code>{{ substr($key->api_key, 0, 10) }}...</code>
                                    </td>
                                    <td class="text-muted">
                                        {{ $key->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <button wire:click="revoke({{ $key->id }})" wire:confirm="Are you sure you want to revoke this key?" class="btn btn-ghost-danger btn-sm">
                                            Revoke
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        No API keys found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
