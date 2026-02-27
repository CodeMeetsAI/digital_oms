<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateCategoryModal extends Component
{
    public $name = '';

    public $search = '';

    public $isCreating = false;

    protected $rules = [
        'name' => 'required|min:3|unique:categories,name',
    ];

    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->get();

        return view('livewire.categories.create-category-modal', [
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

        $category = Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        $this->isCreating = false;
        $this->name = '';

        $this->dispatch('category-created', [
            'id' => $category->id,
            'name' => $category->name,
        ]);
    }

    public function delete($id)
    {
        Category::find($id)->delete();
    }
}
