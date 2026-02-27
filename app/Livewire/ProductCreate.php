<?php

namespace App\Livewire;

use Livewire\Component;

class ProductCreate extends Component
{
    public $type = null; // 'simple', 'service', 'bundle'

    public function selectType($type)
    {
        $this->type = $type;
    }

    public function backToSelection()
    {
        $this->type = null;
    }

    public function render()
    {
        return view('livewire.product-create');
    }
}
