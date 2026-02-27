<?php

namespace App\Livewire\Orders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateOrder extends Component
{
    public $showModal = false;

    // Order Fields
    public $order_date;

    public $external_order_no;

    public $tracking_id;

    public $customer_id;

    public $sales_rep_id;

    public $discount_percentage = 0;

    // Product Search & Table
    public $search_product = '';

    public $products = []; // List of products added to order

    public $searchResults = [];

    // Totals
    public $gross_total = 0;

    public $shipping_charges = 0;

    public $total_discount = 0;

    public $tax = 0;

    public $net_total = 0;

    public $paid_amount = 0;

    // Other
    public $customer_notes;

    public $shipping_method;

    public $payment_method;

    public function mount()
    {
        $this->order_date = now()->format('Y-m-d H:i:s');
    }

    #[On('open-create-order-modal')]
    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->dispatch('show-create-order-modal');
    }

    #[On('customer-created')]
    public function refreshCustomers()
    {
        // Triggers re-render to update customer list
    }

    #[On('product-created')]
    public function handleProductCreated($product)
    {
        if (isset($product['id'])) {
            $this->addProduct($product['id']);
        }
    }

    public function resetForm()
    {
        $this->order_date = now()->format('Y-m-d H:i:s');
        $this->external_order_no = null;
        $this->tracking_id = null;
        $this->customer_id = null;
        $this->sales_rep_id = null;
        $this->discount_percentage = 0;
        $this->products = [];
        $this->search_product = '';
        $this->searchResults = [];
        $this->gross_total = 0;
        $this->shipping_charges = 0;
        $this->total_discount = 0;
        $this->tax = 0;
        $this->net_total = 0;
        $this->paid_amount = 0;
        $this->customer_notes = null;
        $this->shipping_method = null;
        $this->payment_method = null;
    }

    public function render()
    {
        return view('livewire.orders.create-order', [
            'customers' => Customer::all(['id', 'name']),
            'users' => User::all(['id', 'name']),
        ]);
    }

    public function updatedSearchProduct($value)
    {
        if (strlen($value) > 2) {
            $this->searchResults = Product::where('name', 'like', '%'.$value.'%')
                ->orWhere('code', 'like', '%'.$value.'%')
                ->take(5)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    public function addProduct($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $this->products[] = [
                'id' => $product->id,
                'sku' => $product->code, // Assuming code is SKU
                'name' => $product->name,
                'quantity' => 1,
                'unit_price' => $product->selling_price, // Assuming selling_price
                'discount_percent' => 0,
                'discount' => 0,
                'sales_price' => $product->selling_price,
                'tax' => 0, // Need logic for tax
                'sub_total' => $product->selling_price,
            ];
            $this->calculateTotals();
            $this->search_product = '';
            $this->searchResults = [];
        }
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
        $this->calculateTotals();
    }

    public function updatedDiscountPercentage()
    {
        $this->calculateTotals();
    }

    public function updatedShippingCharges()
    {
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $gross = 0;
        $row_discounts = 0;

        foreach ($this->products as $index => $product) {
            $price = floatval($product['unit_price']);
            $qty = intval($product['quantity']);
            $discount_percent = floatval($product['discount_percent']);

            $line_total = $price * $qty;
            $discount_amount = $line_total * ($discount_percent / 100);

            $this->products[$index]['discount'] = $discount_amount;

            // Sub Total in row usually is (Price * Qty - Discount + Tax)
            $sub_total = $line_total - $discount_amount; // + Tax if applicable
            $this->products[$index]['sub_total'] = $sub_total;

            $gross += $line_total;
            $row_discounts += $discount_amount;
        }

        $this->gross_total = $gross;

        $global_discount_amount = $gross * ($this->discount_percentage / 100);
        $this->total_discount = $row_discounts + $global_discount_amount;

        $this->net_total = $this->gross_total - $this->total_discount + $this->tax + floatval($this->shipping_charges);
    }

    public function saveOrder()
    {
        // Validation and Saving Logic
        // ...

        $this->dispatch('order-saved');
        $this->showModal = false;
    }
}
