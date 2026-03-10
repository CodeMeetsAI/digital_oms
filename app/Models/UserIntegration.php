<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'integration_id',
        'platform',
        'store_nickname',
        'store_name',
        'store_url',
        'api_key',
        'api_secret',
        'auto_import_orders',
        'sync_stock',
        'update_product',
        'push_fulfillment',
        'connected_at',
    ];

    protected $casts = [
        'push_fulfil_status' => 'boolean',
        'auto_import_orders' => 'boolean',
        'sync_stock' => 'boolean',
        'update_product_on_import' => 'boolean',
        'connected_at' => 'datetime',
    ];

    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }
}