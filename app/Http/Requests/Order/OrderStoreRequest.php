<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required',
            'payment_type' => 'nullable|string',
            'pay' => 'nullable|numeric',
            'order_date' => 'nullable|date',
            'discount_percentage' => 'nullable|numeric',
            'shipping_charges' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0',
            'items.*.sub_total' => 'required|numeric|min:0',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'order_date' => $this->order_date ?: Carbon::now()->format('Y-m-d H:i:s'),
            'order_status' => OrderStatus::PENDING->value,
            'invoice_no' => IdGenerator::generate([
                'table' => 'orders',
                'field' => 'invoice_no',
                'length' => 10,
                'prefix' => 'INV-',
            ]),
            'payment_type' => $this->payment_type ?: 'cash',
            'pay' => $this->pay ?? 0,
            'discount_percentage' => $this->discount_percentage ?? 0,
            'shipping_charges' => $this->shipping_charges ?? 0,
            'tax' => $this->tax ?? 0,
        ]);
    }
}
