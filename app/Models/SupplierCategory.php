<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierCategory extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'name',
        'slug',
        'tenant_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
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
            ->orWhere('slug', 'like', "%{$value}%");
    }
}
