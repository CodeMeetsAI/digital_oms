<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\PurchaseStatus;
use App\Enums\ShipmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'supplier_id',
        'date',
        'due_date',
        'purchase_no',
        'po_reference',
        'status',
        'payment_status',
        'shipment_status',
        'total_amount',
        'tax_amount',
        'due_amount',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => PurchaseStatus::class,
        'payment_status' => PaymentStatus::class,
        'shipment_status' => ShipmentStatus::class,
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('purchase_no', 'like', "%{$value}%")
            ->orWhereHas('supplier', function ($q) use ($value) {
                $q->where('name', 'like', "%{$value}%");
            });
    }
}
