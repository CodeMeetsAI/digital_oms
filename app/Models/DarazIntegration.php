<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DarazIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_nickname',
        'contact_number',
        'email',
        'store_image',
        'api_url',
        'api_secret',
        'api_key',
        'push_fulfillment',
        'pull_delivery_status',
        'sync_stock',
        'auto_import_orders',
        'customer_category',
        'take_stock_mode',
        'take_stock_location',
        'update_price',
        'auto_import_products',
        'update_product_on_import',
        'auto_generate_sku',
        'fulfill_fbd_location',
    ];
}
