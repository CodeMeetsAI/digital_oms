<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeopardsIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_nickname',
        'courier_company',
        'email',
        'support_no',
        'landline_no',
        'address',
        'account_no',
        'shipper_id',
        'api_key',
        'api_password',
        'default_weight',
        'default_note',
        'auto_sync_fulfillment',
        'set_product_details_remarks',
        'set_product_details_label',
        'allow_open_shipment',
    ];
}
