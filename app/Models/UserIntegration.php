<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIntegration extends Model
{
    use HasFactory;

    protected $table = 'user_integrations'; // Table name

    protected $fillable = [
        'user_id',
        'integration_id',
        'store_nickname',
        'store_name',
        'contact_number',
        'email',
        'store_image',
        'api_url',
        'api_key',
        'api_secret',
        'push_fulfil_status',
        'pull_delivery_status',
        'sync_stock',
        'auto_import_orders',
        'update_price',
        'update_product_on_import',
        'customer_category',
        'auto_import_products',
        'auto_generate_missing_sku',
        'connected_at',
    ];

    // Cast boolean fields
    protected $casts = [
        'push_fulfil_status' => 'boolean',
        'pull_delivery_status' => 'boolean',
        'sync_stock' => 'boolean',
        'auto_import_orders' => 'boolean',
        'update_price' => 'boolean',
        'update_product_on_import' => 'boolean',
        'auto_import_products' => 'boolean',
        'auto_generate_missing_sku' => 'boolean',
        'connected_at' => 'datetime',
    ];

    // Relationships
    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}