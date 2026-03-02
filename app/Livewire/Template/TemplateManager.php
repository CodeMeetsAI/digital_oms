<?php

namespace App\Livewire\Template;

use App\Models\Template;
use Livewire\Component;
use Livewire\WithPagination;

class TemplateManager extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshTable' => '$refresh'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $template = Template::findOrFail($id);
        $template->status = !$template->status;
        $template->save();
        session()->flash('success', 'Status updated successfully.');
    }

    public function delete($id)
    {
        Template::findOrFail($id)->delete();
        session()->flash('success', 'Template deleted successfully.');
    }

    public function exportCsv()
    {
        $fileName = 'templates_' . now()->format('Ymd') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Slug', 'Status', 'Created At']);

            Template::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->when($this->statusFilter !== '', function ($query) {
                $query->where('status', $this->statusFilter);
            })->chunk(100, function($templates) use($file) {
                foreach ($templates as $template) {
                    fputcsv($file, [$template->name, $template->slug, $template->status ? 'Active' : 'Inactive', $template->created_at]);
                }
            });
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $templates = Template::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->when($this->statusFilter !== '', function ($query) {
            $query->where('status', $this->statusFilter);
        })->latest()->paginate(10);

        return view('livewire.template.template-manager', compact('templates'));
    }
}
