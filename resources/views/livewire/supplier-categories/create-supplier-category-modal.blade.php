<div class="modal modal-blur fade" id="modal-supplier-category" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1060;" data-index-url="{{ route('supplier-categories.index') }}" data-store-url="{{ route('supplier-categories.store') }}" data-delete-url-template="{{ route('supplier-categories.destroy', ['supplierCategory' => '__id__']) }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold">Supplier Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex mb-3 gap-2">
                    <input type="text" class="form-control" placeholder="Search" id="supplier-category-search">
                    <button type="button" class="btn btn-warning fw-bold text-dark" id="supplier-category-new">
                        + New
                    </button>
                </div>

                <div class="mb-3 border p-2 rounded bg-light d-none" id="supplier-category-create">
                    <label class="form-label required">Category Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="supplier-category-name" placeholder="Enter category name">
                        <button type="button" class="btn btn-success" id="supplier-category-save">Save</button>
                        <button type="button" class="btn btn-secondary" id="supplier-category-cancel">Cancel</button>
                    </div>
                    <div class="text-danger small mt-1 d-none" id="supplier-category-error"></div>
                </div>

                <div class="list-group list-group-flush overflow-auto" style="max-height: 300px;" id="supplier-category-list"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">Save Changes</button>
            </div>
        </div>
    </div>
</div>

@push('page-scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalEl = document.getElementById('modal-supplier-category');
        if (!modalEl) return;

        const indexUrl = modalEl.dataset.indexUrl;
        const storeUrl = modalEl.dataset.storeUrl;
        const deleteUrlTemplate = modalEl.dataset.deleteUrlTemplate;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        const searchInput = document.getElementById('supplier-category-search');
        const newButton = document.getElementById('supplier-category-new');
        const createBox = document.getElementById('supplier-category-create');
        const nameInput = document.getElementById('supplier-category-name');
        const saveButton = document.getElementById('supplier-category-save');
        const cancelButton = document.getElementById('supplier-category-cancel');
        const errorBox = document.getElementById('supplier-category-error');
        const listEl = document.getElementById('supplier-category-list');

        let searchTimer = null;

        const notifySuccess = (message) => {
            if (window.notyf) {
                window.notyf.success(message);
            }
        };

        const notifyError = (message) => {
            if (window.notyf) {
                window.notyf.error(message);
            }
        };

        const showError = (message) => {
            if (!message) {
                errorBox.textContent = '';
                errorBox.classList.add('d-none');
                return;
            }
            errorBox.textContent = message;
            errorBox.classList.remove('d-none');
        };

        const renderList = (categories) => {
            listEl.innerHTML = '';
            if (!categories.length) {
                const empty = document.createElement('div');
                empty.className = 'text-center text-muted py-3';
                empty.textContent = 'No categories found.';
                listEl.appendChild(empty);
                return;
            }
            categories.forEach((category) => {
                const row = document.createElement('div');
                row.className = 'list-group-item d-flex justify-content-between align-items-center py-2 px-2 border-bottom';

                const name = document.createElement('span');
                name.textContent = category.name;

                const actions = document.createElement('div');
                actions.className = 'btn-list';

                const delButton = document.createElement('button');
                delButton.type = 'button';
                delButton.className = 'btn btn-sm btn-icon btn-danger';
                delButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>';
                delButton.addEventListener('click', () => deleteCategory(category.id));

                actions.appendChild(delButton);
                row.appendChild(name);
                row.appendChild(actions);
                listEl.appendChild(row);
            });
        };

        const fetchCategories = async (search = '') => {
            const url = new URL(indexUrl, window.location.origin);
            if (search) {
                url.searchParams.set('search', search);
            }
            const response = await fetch(url.toString(), {
                headers: {
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            renderList(data.categories || []);
        };

        const addCategoryToSelects = (category) => {
            const selects = document.querySelectorAll('.supplier-category-select');
            selects.forEach((select) => {
                const exists = Array.from(select.options).some((option) => option.value === String(category.id));
                if (!exists) {
                    const option = new Option(category.name, category.id);
                    select.add(option, undefined);
                }
                select.value = category.id;
            });
        };

        const removeCategoryFromSelects = (categoryId) => {
            const selects = document.querySelectorAll('.supplier-category-select');
            selects.forEach((select) => {
                const option = Array.from(select.options).find((opt) => opt.value === String(categoryId));
                if (option) {
                    if (select.value === String(categoryId)) {
                        select.value = '';
                    }
                    option.remove();
                }
            });
        };

        const createCategory = async () => {
            const name = nameInput.value.trim();
            if (!name) {
                showError('Category name is required.');
                return;
            }
            showError('');
            const response = await fetch(storeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ name })
            });
            if (!response.ok) {
                const data = await response.json().catch(() => ({}));
                const message = data.message || data.errors?.name?.[0] || 'Unable to create category.';
                showError(message);
                return;
            }
            const data = await response.json();
            if (data.category) {
                addCategoryToSelects(data.category);
                nameInput.value = '';
                createBox.classList.add('d-none');
                notifySuccess('Category has been created!');
                fetchCategories(searchInput.value.trim());
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            }
        };

        const deleteCategory = async (id) => {
            if (!confirm('Are you sure?')) return;
            const url = deleteUrlTemplate.replace('__id__', id);
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            if (!response.ok) {
                notifyError('Unable to delete category.');
                return;
            }
            removeCategoryFromSelects(id);
            fetchCategories(searchInput.value.trim());
            notifySuccess('Category has been deleted!');
        };

        newButton.addEventListener('click', () => {
            createBox.classList.remove('d-none');
            nameInput.focus();
        });

        cancelButton.addEventListener('click', () => {
            nameInput.value = '';
            showError('');
            createBox.classList.add('d-none');
        });

        saveButton.addEventListener('click', createCategory);

        searchInput.addEventListener('input', () => {
            if (searchTimer) clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                fetchCategories(searchInput.value.trim());
            }, 300);
        });

        modalEl.addEventListener('show.bs.modal', () => {
            fetchCategories(searchInput.value.trim());
        });
    });
</script>
@endpush
