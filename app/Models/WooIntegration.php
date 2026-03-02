<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WooIntegration extends Model
{
    use HasFactory;

    // Specify the table if it doesn't follow Laravel naming convention
    protected $table = 'user_integrations';

    // Mass-assignable fields
    protected $fillable = [
        'store_nickname',
        'contact_number',
        'email',
        'store_image',
        'api_url',
        'consumer_key',
        'consumer_secret',
        'push_fulfillment',
        'auto_import_orders',
        'customer_category',
        'take_stock_mode',
        'take_stock_location',
        'update_price',
        'auto_import_products',
        'sync_stock',
        'update_product_on_import',
        'auto_generate_sku',
    ];

    // Cast boolean fields correctly
    protected $casts = [
        'push_fulfillment' => 'boolean',
        'auto_import_orders' => 'boolean',
        'update_price' => 'boolean',
        'auto_import_products' => 'boolean',
        'sync_stock' => 'boolean',
        'update_product_on_import' => 'boolean',
        'auto_generate_sku' => 'boolean',
    ];
}