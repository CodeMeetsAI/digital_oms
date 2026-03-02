<?php

namespace App\Livewire\Template;

use App\Models\Template;
use Livewire\Component;

class TemplateEdit extends Component
{
    public $templateId;
    public $name;
    public $slug;
    public $content;
    public $status;

    public function mount($template)
    {
        $this->templateId = $template->id;
        $this->name = $template->name;
        $this->slug = $template->slug;
        $this->content = $template->content;
        $this->status = $template->status;
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'slug' => 'required|unique:templates,slug,' . $this->templateId,
            'content' => 'required',
            'status' => 'boolean',
        ];
    }

    public function update()
    {
        $this->validate();

        $template = Template::findOrFail($this->templateId);
        $template->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'content' => $this->content,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Template updated successfully!');
        return redirect()->route('template.index');
    }

    public function render()
    {
        return view('livewire.template.template-edit');
    }
}
