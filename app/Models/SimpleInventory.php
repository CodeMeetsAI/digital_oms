<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SimpleInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'hs_code',
        'product_type',
        'mrp_exclusive_tax',
        'third_schedule',
        'mrp',
        'weight',
        'quantity_sync',
        'barcode',
    ];

    protected $casts = [
        'mrp_exclusive_tax' => 'boolean',
        'third_schedule' => 'boolean',
        'quantity_sync' => 'boolean',
        'weight' => 'decimal:3',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected function mrp(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }
}
