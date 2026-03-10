<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserIntegration;

class Order extends Model
{
    protected $connection = 'tenant'; // VERY IMPORTANT
    protected $fillable = ['order_id', 'user_id', 'status', 'total'];

    // Example method to get WooCommerce integration for this user
    public function getWooIntegration()
    {
        // Make sure tenant connection is active
        return UserIntegration::where('user_id', $this->user_id)
                              ->where('platform', 'woocommerce')
                              ->first();
    }

    public function syncOrder()
    {
        $integration = $this->getWooIntegration();

        if (!$integration) {
            throw new \Exception('User integration not found for WooCommerce.');
        }

        // Your sync logic here
        // Example: call API using $integration->api_key
    }
}