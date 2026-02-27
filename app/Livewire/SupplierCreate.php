<?php

namespace App\Livewire;

use App\Enums\SupplierType;
use App\Models\Supplier;
use App\Models\SupplierCategory;
use Livewire\Component;

class SupplierCreate extends Component
{
    public $name;

    public $shopname; // Company Name

    public $cnic;

    public $ntn;

    public $website;

    public $supplier_category_id;

    public $opening_balance = 0;

    public $type;

    public $address;

    public $phone;

    public $email;

    public $account_holder; // Account Title

    public $account_number;

    public $bank_name;

    public $bank_branch;

    public $iban;

    public $swift;

    public $bank_address;

    public $supplierCategories;

    protected $listeners = [
        'supplier-category-created' => 'refreshSupplierCategories',
    ];

    public function mount()
    {
        $this->supplierCategories = SupplierCategory::all();
        $this->type = SupplierType::DISTRIBUTOR->value; // Default
    }

    protected function rules()
    {
        $tenantId = function_exists('tenant') && tenant() ? tenant('id') : null;

        return [
            'name' => 'required|string|max:255',
            'shopname' => 'nullable|string|max:255',
            'cnic' => 'nullable|string|max:20',
            'ntn' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'supplier_category_id' => 'nullable|exists:supplier_categories,id',
            'opening_balance' => 'nullable|numeric',
            'type' => 'required',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => [
                'nullable',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('suppliers', 'email')
                    ->when($tenantId, fn ($rule) => $rule->where('tenant_id', $tenantId)),
            ],
            'account_holder' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_branch' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:50',
            'swift' => 'nullable|string|max:50',
            'bank_address' => 'nullable|string|max:500',
        ];
    }

    public function store()
    {
        $validatedData = $this->validate();

        $supplier = Supplier::create($validatedData);

        $this->reset([
            'name', 'shopname', 'cnic', 'ntn', 'website', 'supplier_category_id', 'opening_balance',
            'address', 'phone', 'email', 'account_holder', 'account_number',
            'bank_name', 'bank_branch', 'iban', 'swift', 'bank_address',
        ]);

        $this->dispatch('supplier-created', supplier: $supplier);
    }

    public function render()
    {
        return view('livewire.supplier-create');
    }

    public function refreshSupplierCategories($category = null): void
    {
        $this->supplierCategories = SupplierCategory::all();

        if ($category && isset($category['id'])) {
            $this->supplier_category_id = $category['id'];
        }
    }
}
