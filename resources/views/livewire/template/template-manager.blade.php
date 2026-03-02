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
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search templates by name...">
                </div>
                <div class="col-auto">
                    <select wire:model.live="statusFilter" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button wire:click="exportCsv" class="btn btn-outline-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><polyline points="7 11 12 16 17 11" /><line x1="12" y1="4" x2="12" y2="16" /></svg>
                        Export CSV
                    </button>
                    <a href="{{ route('template.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                        New Template
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="w-1">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $template)
                    <tr>
                        <td class="font-weight-medium">{{ $template->name }}</td>
                        <td class="text-muted small">{{ $template->slug }}</td>
                        <td>
                             <div class="form-check form-switch cursor-pointer">
                                <input class="form-check-input" type="checkbox" wire:click="toggleStatus({{ $template->id }})" @if($template->status) checked @endif>
                                <span class="badge {{ $template->status ? 'bg-green-lt' : 'bg-red-lt' }}">
                                    {{ $template->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </td>
                        <td>{{ $template->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('template.show', $template->id) }}" class="btn btn-ghost-primary btn-sm">View</a>
                                <a href="{{ route('template.edit', $template->id) }}" class="btn btn-ghost-primary btn-sm">Edit</a>
                                <button onclick="confirm('Delete this template?') || event.stopImmediatePropagation()" wire:click="delete({{ $template->id }})" class="btn btn-ghost-danger btn-sm">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No templates found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            {{ $templates->links() }}
        </div>
    </div>
</div>
