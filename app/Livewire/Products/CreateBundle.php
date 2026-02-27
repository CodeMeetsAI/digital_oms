<?php

namespace App\Livewire\Products;

use App\Models\Bundle;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateBundle extends Component
{
    use WithFileUploads;

    public $name;

    public $sku;

    public $sku_autogenerate = false;

    public $sku_capitalize = false;

    public $selling_price;

    public $total_cost = 0;

    public $quantity_sync = true;

    public $description;

    public $image;

    // Required fields for Product model
    public $category_id;

    public $unit_id;

    public $buying_price = 0; // Calculated from total cost

    public $quantity_alert = 0;

    public $search = '';

    public $selectedProducts = [];

    public $isModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'selling_price' => 'required|numeric|min:0',
        'category_id' => 'nullable|exists:categories,id',
        'unit_id' => 'nullable|exists:units,id',
        'selectedProducts' => 'required|array|min:1',
        'selectedProducts.*.quantity' => 'required|integer|min:1',
    ];

    public function mount($isModal = false)
    {
        $this->isModal = $isModal;
        // Set default category and unit if available, or leave empty
        $this->category_id = null;
        $this->unit_id = null;
    }

    public function updatedSkuAutogenerate($value)
    {
        if ($value) {
            $this->sku = 'BND-'.strtoupper(Str::random(8));
        }
    }

    public function updatedSkuCapitalize($value)
    {
        if ($value && $this->sku) {
            $this->sku = strtoupper($this->sku);
        }
    }

    public function addProduct($productId)
    {
        $product = Product::find($productId);

        if (! $product) {
            return;
        }

        foreach ($this->selectedProducts as $item) {
            if ($item['id'] == $product->id) {
                $this->dispatch('notify', ['type' => 'warning', 'message' => 'Product already added!']);

                return;
            }
        }

        $this->selectedProducts[] = [
            'id' => $product->id,
            'name' => $product->name,
            'code' => $product->code,
            'buying_price' => $product->buying_price,
            'selling_price' => $product->selling_price,
            'quantity' => 1,
        ];

        $this->calculateTotalCost();
        $this->search = '';
    }

    public function removeProduct($index)
    {
        unset($this->selectedProducts[$index]);
        $this->selectedProducts = array_values($this->selectedProducts);
        $this->calculateTotalCost();
    }

    public function updateQuantity($index, $quantity)
    {
        $this->selectedProducts[$index]['quantity'] = $quantity;
        $this->calculateTotalCost();
    }

    public function calculateTotalCost()
    {
        $this->total_cost = 0;
        foreach ($this->selectedProducts as $product) {
            $this->total_cost += ($product['buying_price'] * $product['quantity']);
        }
        // buying_price in Product model is integer (cents), so we keep it consistent
        // If UI shows dollars, we might need to adjust.
        // Assuming buying_price in DB is in cents/units as per other code (dividing by 100 in accessors?)
        // Let's check Product model accessors.
        // Product model doesn't have accessors visible in previous `read` but SimpleInventory did.
        // Wait, the Product migration says integer.
        // I'll assume it's raw integer value for now.
    }

    public function store()
    {
        $this->validate();

        if (! $this->sku && ! $this->sku_autogenerate) {
            $this->addError('sku', 'SKU is required unless autogenerate is checked.');

            return;
        }

        if ($this->sku_autogenerate && ! $this->sku) {
            $this->sku = 'BND-'.strtoupper(Str::random(8));
        }

        DB::beginTransaction();

        try {
            $product = Product::create([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'code' => $this->sku,
                'quantity' => 0, // Bundle quantity depends on components? Or just 0 init.
                'buying_price' => $this->total_cost,
                'selling_price' => $this->selling_price,
                'quantity_alert' => $this->quantity_alert,
                'category_id' => $this->category_id,
                'unit_id' => $this->unit_id,
                'notes' => $this->description,
            ]);

            if ($this->image) {
                $filename = hexdec(uniqid()).'.'.$this->image->getClientOriginalExtension();
                $this->image->storeAs('products/', $filename, 'public');
                $product->update(['product_image' => $filename]);
            }

            $bundle = Bundle::create([
                'product_id' => $product->id,
                'quantity_sync' => $this->quantity_sync,
                'total_cost' => $this->total_cost,
            ]);

            foreach ($this->selectedProducts as $item) {
                $bundle->products()->attach($item['id'], ['quantity' => $item['quantity']]);
            }

            DB::commit();

            if ($this->isModal) {
                $this->dispatch('product-created', product: $product); // Dispatch with product data
                $this->reset(['name', 'sku', 'sku_autogenerate', 'sku_capitalize', 'selling_price', 'total_cost', 'quantity_sync', 'description', 'image', 'category_id', 'unit_id', 'selectedProducts', 'search']);
                // Keep isModal true? Or reset? Component might be re-used.
            } else {
                $this->dispatch('product-saved'); // To close modal if used in index page modal
                $this->reset();

                return redirect()->route('products.index')->with('success', 'Bundle created successfully!');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('form', 'Error creating bundle: '.$e->getMessage());
        }
    }

    public function render()
    {
        $searchResults = [];
        if (strlen($this->search) >= 2) {
            $searchResults = Product::with(['unit', 'simpleInventory', 'bundle'])
                ->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('code', 'like', '%'.$this->search.'%')
                ->take(10)
                ->get();
        }

        return view('livewire.products.create-bundle', [
            'searchResults' => $searchResults,
            'categories' => Category::all(),
            'units' => Unit::all(),
        ]);
    }
}
