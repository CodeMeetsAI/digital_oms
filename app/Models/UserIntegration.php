<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIntegration extends Model
{
    use HasFactory;

    /**
     * Fillable fields aligned with the database columns
     */
    protected $fillable = [
        'user_id',
        'integration_id',
        'platform',
        'store_nickname',
        'store_name',
        'store_url',        // Added to match your controller input
        'api_key',
        'api_secret',
        'auto_import_orders',
        'sync_stock',
        'update_product',   // renamed to match database column
        'push_fulfillment', // renamed to match database column
        'connected_at',     // optional timestamp
    ];

    /**
     * Casts for proper data handling
     */
 protected $casts = [
    // 'api_key' => 'encrypted',
    // 'api_secret' => 'encrypted',
    'push_fulfil_status' => 'boolean',
    'auto_import_orders' => 'boolean',
    'sync_stock' => 'boolean',
    'update_product_on_import' => 'boolean',
    'connected_at' => 'datetime',
];

    /**
     * Relationship with Integration model
     */
    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }
}