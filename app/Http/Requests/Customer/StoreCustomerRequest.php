<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:25|unique:customers,phone',
            'category_id' => 'nullable|exists:customer_categories,id',
            'opening_balance' => 'nullable|numeric',
            'opening_balance_type' => 'nullable|in:receivable,payable',
            'discount' => 'nullable|numeric|min:0|max:100',
            'cnic' => 'nullable|string|max:255',
            'ntn' => 'nullable|string|max:255',
            'billing_name' => 'nullable|string|max:255',
            'billing_phone' => 'nullable|string|max:25',
            'billing_address_line_1' => 'nullable|string|max:255',
            'billing_address_line_2' => 'nullable|string|max:255',
            'billing_address_line_3' => 'nullable|string|max:255',
            'billing_address_line_4' => 'nullable|string|max:255',
            'billing_country' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:255',
            'shipping_name' => 'nullable|string|max:255',
            'shipping_phone' => 'nullable|string|max:25',
            'shipping_address_line_1' => 'nullable|string|max:255',
            'shipping_address_line_2' => 'nullable|string|max:255',
            'shipping_address_line_3' => 'nullable|string|max:255',
            'shipping_address_line_4' => 'nullable|string|max:255',
            'shipping_country' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:255',
            'account_holder' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ];
    }
}
