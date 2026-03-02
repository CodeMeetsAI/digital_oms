<div class="card card-md">
    <div class="card-body">
        <form wire:submit.prevent="save">
            <div class="row row-cards">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Template Name</label>
                        <input type="text" wire:model.live="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Sales Invoice">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Slug (Optional)</label>
                        <input type="text" wire:model="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="e.g. sales-invoice">
                        @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3" wire:ignore>
                        <label class="form-label required">Template Content</label>
                        <div id="editor" style="height: 300px;">{!! $content !!}</div>
                    </div>
                    @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                     <div class="mb-3">
                        <label class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" wire:model="status">
                            <span class="form-check-label">Status: Active</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('template.index') }}" class="btn btn-link">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Template</button>
            </div>
        </form>
    </div>

    <!-- Quill Editor Integration -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const quill = new Quill('#editor', {
                theme: 'snow'
            });
            quill.on('text-change', function() {
                @this.set('content', quill.root.innerHTML);
            });
        });
    </script>
</div>
