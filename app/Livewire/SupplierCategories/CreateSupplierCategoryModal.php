<?php

namespace App\Livewire\SupplierCategories;

use App\Models\SupplierCategory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateSupplierCategoryModal extends Component
{
    public $name = '';

    public $search = '';

    public $isCreating = false;

    protected function rules(): array
    {
        $tenantId = function_exists('tenant') && tenant() ? tenant('id') : null;

        return [
            'name' => [
                'required',
                'min:3',
                Rule::unique('supplier_categories', 'name')
                    ->when($tenantId, fn ($rule) => $rule->where('tenant_id', $tenantId)),
            ],
        ];
    }

    public function render()
    {
        $categories = SupplierCategory::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->get();

        return view('livewire.supplier-categories.create-supplier-category-modal', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $this->isCreating = true;
        $this->name = '';
    }

    public function cancel()
    {
        $this->isCreating = false;
        $this->name = '';
    }

    public function save()
    {
        $this->validate();

        $category = SupplierCategory::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        $this->isCreating = false;
        $this->name = '';

        $this->dispatch('supplier-category-created', [
            'id' => $category->id,
            'name' => $category->name,
        ]);
    }

    public function delete($id)
    {
        SupplierCategory::find($id)->delete();
    }
}
