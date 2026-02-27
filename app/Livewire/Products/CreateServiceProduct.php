<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateServiceProduct extends Component
{
    use WithFileUploads;

    public $name;

    public $code;

    public $sku_autogenerate = false;

    public $hs_code;

    public $notes;

    // Service specific
    public $category_id;

    public $mrp_exclusive_tax = false;

    public $third_schedule = false;

    // Prices
    public $buying_price;

    public $selling_price;

    public $mrp;

    // More Info
    public $quantity_alert = 0;

    public $weight = 0;

    public $barcode;

    public $barcode_autogenerate = false;

    public $product_image;

    // Unit is hidden/default for service
    public $unit_id;

    public $isModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:255|unique:products,code',
        'category_id' => 'required|exists:categories,id',
        'buying_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'quantity_alert' => 'nullable|numeric|min:0',
        'weight' => 'nullable|numeric|min:0',
    ];

    public function mount($isModal = false)
    {
        $this->isModal = $isModal;
        // Set default unit if exists
        $this->unit_id = Unit::first()->id ?? null;
    }

    public function updatedSkuAutogenerate($value)
    {
        if ($value) {
            $this->code = 'SVC-'.mt_rand(10000000, 99999999);
        }
    }

    public function updatedBarcodeAutogenerate($value)
    {
        if ($value) {
            $this->barcode = mt_rand(100000000000, 999999999999);
        }
    }

    public function store()
    {
        if ($this->sku_autogenerate && empty($this->code)) {
            $this->code = 'SVC-'.mt_rand(10000000, 99999999);
        }

        $this->validate();

        DB::beginTransaction();

        try {
            $productData = [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'code' => $this->code,
                'category_id' => $this->category_id,
                'unit_id' => $this->unit_id,
                'buying_price' => $this->buying_price,
                'selling_price' => $this->selling_price,
                'quantity' => 0,
                'quantity_alert' => $this->quantity_alert ?? 0,
                'notes' => $this->notes,
                'tax' => 0,
                'tax_type' => 1,
            ];

            if ($this->product_image) {
                $filename = hexdec(uniqid()).'.'.$this->product_image->getClientOriginalExtension();
                $this->product_image->storeAs('products/', $filename, 'public');
                $productData['product_image'] = $filename;
            }

            $product = Product::create($productData);

            $product->simpleInventory()->create([
                'mrp' => $this->mrp ?? 0,
                'weight' => $this->weight ?? 0,
                'product_type' => 'service',
                'mrp_exclusive_tax' => $this->mrp_exclusive_tax,
                'third_schedule' => $this->third_schedule,
                'quantity_sync' => false, // Services usually don't sync quantity?
            ]);

            DB::commit();

            if ($this->isModal) {
                $this->dispatch('product-created', product: $product);
                $this->reset();
            } else {
                return redirect()->route('products.index')->with('success', 'Service created successfully!');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('form', 'Error creating service: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.products.create-service-product', [
            'categories' => Category::all(),
        ]);
    }
}
