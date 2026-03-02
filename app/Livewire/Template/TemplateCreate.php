<?php

namespace App\Livewire\Template;

use App\Models\Template;
use Livewire\Component;

class TemplateCreate extends Component
{
    public $name;
    public $slug;
    public $content;
    public $status = true;

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'slug' => 'nullable|unique:templates,slug',
        'content' => 'required',
        'status' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        Template::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'content' => $this->content,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Template created successfully!');
        return redirect()->route('template.index');
    }

    public function render()
    {
        return view('livewire.template.template-create');
    }
}
