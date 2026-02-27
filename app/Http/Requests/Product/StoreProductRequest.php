<?php

namespace App\Http\Requests\Product;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductRequest extends FormRequest
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
            'product_image' => 'image|file|max:2048',
            'name' => 'required|string',
            'slug' => 'required|unique:products',
            'category_id' => 'nullable|integer',
            'unit_id' => 'nullable|integer',
            'quantity' => 'required|integer',
            'buying_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'quantity_alert' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'tax_type' => 'nullable|integer',
            'notes' => 'nullable|max:1000',
            'hs_code' => 'nullable|string',
            'product_type' => 'nullable|string',
            'mrp_exclusive_tax' => 'nullable|in:on,off,1,0,true,false',
            'third_schedule' => 'nullable|in:on,off,1,0,true,false',
            'mrp' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'quantity_sync' => 'nullable|in:on,off,1,0,true,false',
            'barcode' => 'nullable|string',
            'code' => 'nullable|string|unique:products,code',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->name, '-'),
        ]);

        if (! $this->has('code') || empty($this->code)) {
            $this->merge([
                'code' => IdGenerator::generate([
                    'table' => 'products',
                    'field' => 'code',
                    'length' => 4,
                    'prefix' => 'PC',
                ]),
            ]);
        }
    }
}
