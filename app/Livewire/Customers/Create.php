<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Models\CustomerCategory;
use Livewire\Component;

class Create extends Component
{
    // Personal Details
    public $name;

    public $category_id;

    public $opening_balance = 0;

    public $opening_balance_type = 'receivable';

    public $discount = 0;

    // Contact Details
    public $email;

    public $phone;

    public $cnic;

    public $ntn;

    // Billing Address
    public $billing_name;

    public $billing_phone;

    public $billing_address_line_1;

    public $billing_address_line_2;

    public $billing_address_line_3;

    public $billing_address_line_4;

    public $billing_country;

    public $billing_city;

    // Shipping Address
    public $shipping_name;

    public $shipping_phone;

    public $shipping_address_line_1;

    public $shipping_address_line_2;

    public $shipping_address_line_3;

    public $shipping_address_line_4;

    public $shipping_country;

    public $shipping_city;

    public $copy_billing_to_shipping = false;

    protected $listeners = ['category-created' => '$refresh'];

    public function render()
    {
        return view('livewire.customers.create', [
            'categories' => CustomerCategory::all(),
        ]);
    }

    public function updatedCopyBillingToShipping($value)
    {
        if ($value) {
            $this->shipping_name = $this->billing_name;
            $this->shipping_phone = $this->billing_phone;
            $this->shipping_address_line_1 = $this->billing_address_line_1;
            $this->shipping_address_line_2 = $this->billing_address_line_2;
            $this->shipping_address_line_3 = $this->billing_address_line_3;
            $this->shipping_address_line_4 = $this->billing_address_line_4;
            $this->shipping_country = $this->billing_country;
            $this->shipping_city = $this->billing_city;
        } else {
            $this->shipping_name = null;
            $this->shipping_phone = null;
            $this->shipping_address_line_1 = null;
            $this->shipping_address_line_2 = null;
            $this->shipping_address_line_3 = null;
            $this->shipping_address_line_4 = null;
            $this->shipping_country = null;
            $this->shipping_city = null;
        }
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'category_id' => 'nullable|exists:customer_categories,id',
            'opening_balance' => 'nullable|numeric',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);

        Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'category_id' => $this->category_id,
            'opening_balance' => $this->opening_balance,
            'opening_balance_type' => $this->opening_balance_type,
            'discount' => $this->discount,
            'cnic' => $this->cnic,
            'ntn' => $this->ntn,

            // Billing
            'billing_name' => $this->billing_name,
            'billing_phone' => $this->billing_phone,
            'billing_address_line_1' => $this->billing_address_line_1,
            'billing_address_line_2' => $this->billing_address_line_2,
            'billing_address_line_3' => $this->billing_address_line_3,
            'billing_address_line_4' => $this->billing_address_line_4,
            'billing_country' => $this->billing_country,
            'billing_city' => $this->billing_city,

            // Shipping
            'shipping_name' => $this->shipping_name,
            'shipping_phone' => $this->shipping_phone,
            'shipping_address_line_1' => $this->shipping_address_line_1,
            'shipping_address_line_2' => $this->shipping_address_line_2,
            'shipping_address_line_3' => $this->shipping_address_line_3,
            'shipping_address_line_4' => $this->shipping_address_line_4,
            'shipping_country' => $this->shipping_country,
            'shipping_city' => $this->shipping_city,
        ]);

        $this->reset();
        $this->dispatch('customer-created');
    }
}
