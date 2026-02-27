<?php

namespace App\Livewire;

use App\Enums\PaymentStatus;
use App\Enums\PurchaseStatus;
use App\Enums\ShipmentStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class PurchaseForm extends Component
{
    use WithFileUploads;

    // Header Fields
    public $supplier_id;

    public $po_reference;

    public $date;

    public $due_date;

    public $discount_percentage = 0;

    public $supplier_notes;

    public $attachments; // For file upload

    // Search
    public $searchProduct = '';

    public $searchResults = [];

    // Lines
    public $invoiceProducts = []; // [product_id, sku, name, quantity, unit_price, discount_percentage, tax_amount, sub_total]

    // Summary
    public $gross_amount = 0;

    public $total_discount = 0;

    public $total_tax = 0;

    public $net_amount = 0;

    public $paid_amount = 0;

    public $suppliers;

    public $categories;

    public function mount()
    {
        $this->date = Carbon::now()->format('Y-m-d');
        $this->due_date = Carbon::now()->addDays(30)->format('Y-m-d');
        $this->suppliers = Supplier::select('id', 'name')->get();
        $this->categories = Category::select('id', 'name')->get();

        // Initialize with one empty row if needed, or just empty
    }

    public function updatedSearchProduct()
    {
        if (strlen($this->searchProduct) > 2) {
            $this->searchResults = Product::where('name', 'like', '%'.$this->searchProduct.'%')
                ->orWhere('code', 'like', '%'.$this->searchProduct.'%')
                ->limit(10)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    public function selectProduct($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            // Check if product already exists in list
            foreach ($this->invoiceProducts as $key => $item) {
                if ($item['product_id'] == $product->id) {
                    $this->invoiceProducts[$key]['quantity']++;
                    $this->calculateRow($key);
                    $this->calculateTotals();
                    $this->searchProduct = '';
                    $this->searchResults = [];

                    return;
                }
            }

            // Add new row
            $this->invoiceProducts[] = [
                'product_id' => $product->id,
                'sku' => $product->code,
                'name' => $product->name,
                'quantity' => 1,
                'unit_price' => $product->buying_price, // Assuming buying_price is float/double
                'discount_percentage' => 0,
                'tax_amount' => $product->tax ?? 0, // Default tax from product
                'sub_total' => 0, // Will be calculated
            ];

            $this->calculateRow(count($this->invoiceProducts) - 1);
            $this->calculateTotals();
        }

        $this->searchProduct = '';
        $this->searchResults = [];
    }

    public function removeProduct($index)
    {
        unset($this->invoiceProducts[$index]);
        $this->invoiceProducts = array_values($this->invoiceProducts);
        $this->calculateTotals();
    }

    public function updatedInvoiceProducts($value, $key)
    {
        // $key is like 0.quantity
        $parts = explode('.', $key);
        if (count($parts) == 2) {
            $index = $parts[0];
            $this->calculateRow($index);
            $this->calculateTotals();
        }
    }

    public function updatedDiscountPercentage()
    {
        $this->calculateTotals();
    }

    #[On('supplier-created')]
    public function supplierCreated($supplier)
    {
        $this->suppliers = Supplier::select('id', 'name')->get();
        $this->supplier_id = $supplier['id'];
        $this->dispatch('close-modal', modal: '#modal-purchase-supplier');
    }

    #[On('product-created')]
    public function productCreated($product)
    {
        $this->selectProduct($product['id']);
        $this->dispatch('close-modal', modal: '#modal-purchase-product');
    }

    public function calculateRow($index)
    {
        if (! isset($this->invoiceProducts[$index])) {
            return;
        }

        $row = &$this->invoiceProducts[$index];
        $qty = (float) $row['quantity'];
        $price = (float) $row['unit_price'];
        $discountPct = (float) $row['discount_percentage'];
        $tax = (float) $row['tax_amount'];

        $amount = $qty * $price;
        $discountAmount = $amount * ($discountPct / 100);

        // Assuming tax is a fixed amount per unit or total?
        // If tax_amount is per unit: $taxTotal = $qty * $tax;
        // If tax_amount is total for line: $taxTotal = $tax;
        // Let's assume tax_amount in row is TOTAL tax for that line (user input or calculated)
        // But usually tax is % or fixed per unit.
        // The mockup shows "Tax" column. Let's assume it's the Tax Amount for the line.

        $row['sub_total'] = $amount - $discountAmount + $tax;
    }

    public function calculateTotals()
    {
        $this->gross_amount = 0;
        $line_discounts = 0;
        $this->total_tax = 0;

        foreach ($this->invoiceProducts as $row) {
            $qty = (float) $row['quantity'];
            $price = (float) $row['unit_price'];
            $lineAmount = $qty * $price;

            $this->gross_amount += $lineAmount;

            $lineDiscount = $lineAmount * ((float) $row['discount_percentage'] / 100);
            $line_discounts += $lineDiscount;

            $this->total_tax += (float) $row['tax_amount'];
        }

        // Apply global discount on remaining amount? Or on gross?
        // Usually Global Discount is applied on the Total.
        // Let's say Total Discount = Sum(Line Discounts) + Global Discount Amount.
        // Global Discount Amount = (Gross - Line Discounts) * Global % / 100

        $globalDiscountAmount = ($this->gross_amount - $line_discounts) * ((float) $this->discount_percentage / 100);

        $this->total_discount = $line_discounts + $globalDiscountAmount;

        $this->net_amount = $this->gross_amount - $this->total_discount + $this->total_tax;
    }

    public function store()
    {
        $this->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required|date',
            'invoiceProducts' => 'required|array|min:1',
            'invoiceProducts.*.quantity' => 'required|numeric|min:1',
            'invoiceProducts.*.unit_price' => 'required|numeric|min:0',
            'attachments' => 'nullable|file|max:10240', // 10MB max
        ]);

        DB::transaction(function () {
            $purchase = Purchase::create([
                'supplier_id' => $this->supplier_id,
                'date' => $this->date,
                'due_date' => $this->due_date,
                'purchase_no' => 'PO-'.strtoupper(uniqid()), // Should probably be auto-generated sequentially
                'po_reference' => $this->po_reference,
                'status' => PurchaseStatus::PENDING,
                'payment_status' => PaymentStatus::UNPAID,
                'shipment_status' => ShipmentStatus::UNFULFILLED,
                'total_amount' => $this->net_amount,
                'tax_amount' => $this->total_tax,
                'discount_percentage' => $this->discount_percentage,
                'discount_amount' => $this->total_discount,
                'notes' => $this->supplier_notes,
                'created_by' => auth()->id(),
            ]);

            foreach ($this->invoiceProducts as $item) {
                $purchase->details()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unitcost' => $item['unit_price'] * 100, // Store in cents if that's the convention, or model accessor handles it?
                    // Wait, PurchaseDetails model doesn't have accessors for unitcost.
                    // The previous code used $product->buying_price which is accessed via accessor (value/100).
                    // So if I have 25.00 here, I should store 2500.
                    // Let's check PurchaseDetails model or migration.
                    // Migration says integer 'unitcost'. So yes, cents.
                    'total' => $item['sub_total'] * 100,
                    'product_discount_percentage' => $item['discount_percentage'],
                    'product_discount_amount' => ($item['quantity'] * $item['unit_price'] * $item['discount_percentage'] / 100) * 100,
                    'product_tax_amount' => $item['tax_amount'] * 100,
                ]);

                // Update product quantity? Usually done on "Received" status.
            }

            // Handle attachments if any
            if ($this->attachments) {
                $path = $this->attachments->store('purchases', 'public');
                $purchase->update(['document' => $path]);
            }
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase Order created successfully.');
    }

    public function render(): View
    {
        return view('livewire.purchase-form');
    }
}
