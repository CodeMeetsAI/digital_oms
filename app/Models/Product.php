<?php

namespace App\Models;

use App\Enums\TaxType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $fillable = [
        'name',
        'slug',
        'code',
        'quantity',
        'quantity_alert',
        'buying_price',
        'selling_price',
        'tax',
        'tax_type',
        'notes',
        'product_image',
        'category_id',
        'unit_id',
        'created_at',
        'updated_at',

        // ✅ External platform fields for sync
        'platform_product_id',  // ID from WooCommerce / Shopify / Daraz
        'platform',             // 'woocommerce', 'shopify', 'daraz'
        'external_description', // Optional: description from external platform
        'external_price',       // Optional: price from external platform
        'external_stock',       // Optional: stock quantity from external platform
        'external_image_url',   // Optional: main image URL from platform
        'user_id',              // Which tenant/user owns this product
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tax_type' => TaxType::class,
        'external_price' => 'decimal:2',
        'external_stock' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function simpleInventory(): HasOne
    {
        return $this->hasOne(SimpleInventory::class);
    }

    public function bundle(): HasOne
    {
        return $this->hasOne(Bundle::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    protected function buyingPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    protected function sellingPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('code', 'like', "%{$value}%");
    }
}