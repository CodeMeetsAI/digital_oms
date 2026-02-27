<div class="modal modal-blur fade" id="modal-category" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Product Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex mb-3 gap-2">
                    <input type="text" class="form-control" placeholder="Search" wire:model.live="search">
                    <button class="btn btn-warning fw-bold text-dark" wire:click="create">
                        + New
                    </button>
                </div>

                @if($isCreating)
                    <div class="mb-3 border p-2 rounded bg-light">
                        <label class="form-label required">Category Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="Enter category name">
                            <button class="btn btn-success" wire:click="save">Save</button>
                            <button class="btn btn-secondary" wire:click="cancel">Cancel</button>
                        </div>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                @endif

                <div class="list-group list-group-flush overflow-auto" style="max-height: 300px;">
                    @forelse($categories as $category)
                        <div class="list-group-item d-flex justify-content-between align-items-center py-2 px-2 border-bottom">
                            <span>{{ $category->name }}</span>
                            <div class="btn-list">
                                <button class="btn btn-sm btn-icon btn-danger" wire:click="delete({{ $category->id }})"
                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                </button>
                                <button class="btn btn-sm btn-icon btn-warning text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sitemap" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M15 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M6 15v-1a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v1" /><path d="M12 9l0 3" /></svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            No categories found.
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">Save Changes</button>
            </div>
        </div>
    </div>
</div>
