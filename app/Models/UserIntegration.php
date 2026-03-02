<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIntegration extends Model
{
    use HasFactory;

    protected $fillable = [
        'integration_id',
        'platform',
        'store_nickname',
        'store_url',
        'api_key',
        'secret_key',
        'access_token',
        'refresh_token',
        'expires_in',
        'status',
        'sample_product_count',
        'last_sync_at',
    ];

    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }
}
