<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'status',
        'balance',
        'payment_mode',
        'assigned_user',
    ];

    protected $casts = [
        'status' => 'boolean',
        'balance' => 'decimal:2',
    ];

    public function scopeSearch($query, $value): void
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('code', 'like', "%{$value}%")
            ->orWhere('type', 'like', "%{$value}%");
    }
}
