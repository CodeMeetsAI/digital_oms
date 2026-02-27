<?php

namespace App\Models;

use App\Enums\SupplierType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'shopname',
        'type',
        'photo',
        'account_holder',
        'account_number',
        'bank_name',
        'cnic',
        'ntn',
        'website',
        'supplier_category_id',
        'opening_balance',
        'bank_branch',
        'iban',
        'swift',
        'bank_address',
        'status',
        'tenant_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'type' => SupplierType::class,
        'status' => 'boolean',
    ];

    public function supplierCategory()
    {
        return $this->belongsTo(SupplierCategory::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    protected static function booted(): void
    {
        if (function_exists('tenant') && tenant()) {
            static::addGlobalScope('tenant', function (Builder $builder) {
                $builder->where('tenant_id', tenant('id'));
            });

            static::creating(function (self $model) {
                if (! $model->tenant_id) {
                    $model->tenant_id = tenant('id');
                }
            });
        }
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%")
            ->orWhere('phone', 'like', "%{$value}%")
            ->orWhere('shopname', 'like', "%{$value}%")
            ->orWhere('type', 'like', "%{$value}%")
            ->orWhere('cnic', 'like', "%{$value}%")
            ->orWhere('ntn', 'like', "%{$value}%");
    }
}
