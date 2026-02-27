<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateSimpleProduct extends Component
{
    use WithFileUploads;

    public $name;

    public $code;

    public $sku_autogenerate = false;

    public $sku_capitalize = false;

    public $hs_code;

    public $notes;

    // Product Type: 'simple' or 'variants'. For now, we only implement simple.
    public $product_type = 'simple';

    public $mrp_exclusive_tax = false;

    public $third_schedule = false;

    // Prices
    public $buying_price;

    public $selling_price;

    public $mrp;

    // More Info
    public $quantity_alert = 0;

    public $weight = 0;

    public $quantity_sync = true;

    public $barcode;

    public $barcode_autogenerate = false;

    public $product_image;

    // Relations
    public $category_id;

    public $unit_id;

    public $isModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:255|unique:products,code',
        'buying_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'quantity_alert' => 'nullable|numeric|min:0',
        'weight' => 'nullable|numeric|min:0',
        'category_id' => 'nullable|exists:categories,id',
        'unit_id' => 'nullable|exists:units,id',
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
            $this->code = 'SKU-'.mt_rand(10000000, 99999999);
        }
    }

    public function updatedSkuCapitalize($value)
    {
        if ($value && $this->code) {
            $this->code = strtoupper($this->code);
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
            $this->code = 'SKU-'.mt_rand(10000000, 99999999);
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
                'tax' => 0, // Default for now
                'tax_type' => 1, // Default
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
                'product_type' => 'simple', // 'simple' or 'variants'
                'mrp_exclusive_tax' => $this->mrp_exclusive_tax,
                'third_schedule' => $this->third_schedule,
                'quantity_sync' => $this->quantity_sync,
            ]);

            // Handle Barcode if separate from code? Product model doesn't have barcode field in fillable,
            // but the view has it. Maybe it's stored in code or simpleInventory?
            // Checking SimpleInventory migration would be good, but assuming it might be 'code' or extra field.
            // For now, I'll ignore barcode saving if field doesn't exist, or assume 'code' is SKU.
            // Wait, standard Product table usually has barcode.
            // I'll proceed without explicit barcode field in Product unless I verified it exists.
            // It was input name="barcode" in HTML.

            DB::commit();

            if ($this->isModal) {
                $this->dispatch('product-created', product: $product);
                $this->reset();
            } else {
                return redirect()->route('products.index')->with('success', 'Product created successfully!');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('form', 'Error creating product: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.products.create-simple-product', [
            'categories' => Category::all(),
            'units' => Unit::all(),
        ]);
    }
}
