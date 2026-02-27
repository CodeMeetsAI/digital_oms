<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
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
        $tenantId = function_exists('tenant') && tenant() ? tenant('id') : null;

        return [
            'photo' => [
                'image',
                'file',
                'max:1024',
            ],
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'email' => [
                'nullable',
                'email',
                'max:50',
                Rule::unique('suppliers', 'email')
                    ->ignore($this->supplier)
                    ->when($tenantId, fn ($rule) => $rule->where('tenant_id', $tenantId)),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:25',
                Rule::unique('suppliers', 'phone')
                    ->ignore($this->supplier)
                    ->when($tenantId, fn ($rule) => $rule->where('tenant_id', $tenantId)),
            ],
            'shopname' => [
                'nullable',
                'string',
                'max:50',
            ],
            'type' => [
                'required',
                'string',
                'max:25',
            ],
            'account_holder' => [
                'nullable',
                'max:50',
            ],
            'account_number' => [
                'nullable',
                'max:25',
            ],
            'bank_name' => [
                'nullable',
                'max:25',
            ],
            'address' => [
                'nullable',
                'string',
                'max:100',
            ],
            'cnic' => [
                'nullable',
                'string',
                'max:20',
            ],
            'ntn' => [
                'nullable',
                'string',
                'max:20',
            ],
            'website' => [
                'nullable',
                'url',
                'max:100',
            ],
            'supplier_category_id' => [
                'nullable',
                'exists:supplier_categories,id',
            ],
            'opening_balance' => [
                'nullable',
                'numeric',
            ],
            'bank_branch' => [
                'nullable',
                'string',
                'max:50',
            ],
            'iban' => [
                'nullable',
                'string',
                'max:50',
            ],
            'swift' => [
                'nullable',
                'string',
                'max:20',
            ],
            'bank_address' => [
                'nullable',
                'string',
                'max:100',
            ],
            'status' => [
                'boolean',
            ],
        ];
    }
}
