<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use App\Models\UserIntegration;
use App\Models\Integration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WooCommerceOAuthController extends Controller
{
    /**
     * Redirect the user to the WooCommerce Authorization page.
     */
    public function connect(Request $request)
    {
        $request->validate([
            'store_url' => 'required|url'
        ]);

        $baseUrl = rtrim($request->store_url, '/');
        $appName = config('app.name', 'Laravel OMS');
        
        // Scope defines permissions: read_write is usually needed for OMS
        $scope = 'read_write';
        $userId = auth()->id();
        
        // WooCommerce REQUIRES HTTPS for the callback_url. 
        // Use ngrok for localhost testing.
        $returnUrl = route('automation.integrations.woocommerce.callback', ['status' => 'success']);
        $callbackUrl = route('automation.integrations.woocommerce.callback');

        $query = http_build_query([
            'app_name' => $appName,
            'scope' => $scope,
            'user_id' => $userId,
            'return_url' => $returnUrl,
            'callback_url' => $callbackUrl,
        ]);

        $authUrl = $baseUrl . '/wc-auth/v1/authorize?' . $query;

        Log::info("WC OAuth: Redirecting user to $authUrl");

        return redirect($authUrl);
    }

    /**
     * Handle the callback from WooCommerce.
     * WooCommerce sends data via POST to the callback_url and redirects user to return_url.
     */
    public function callback(Request $request)
    {
        // 1. Handle POST from WooCommerce (The actual key delivery)
        if ($request->isMethod('post')) {
            $data = $request->all();
            Log::info("WC OAuth Callback Received Keys", $data);

            if (isset($data['consumer_key']) && isset($data['consumer_secret'])) {
                // Retrieve the central integration record
                $integration = Integration::where('slug', 'woocommerce')->first();

                // Save to tenant database
                UserIntegration::updateOrCreate(
                    ['platform' => 'woocommerce'],
                    [
                        'integration_id' => $integration->id ?? null,
                        'api_key' => $data['consumer_key'],
                        'secret_key' => $data['consumer_secret'],
                        'store_url' => $data['user_id'] ?? $request->root(), // In WC flow user_id usually contains the store URL or similar
                        'status' => 'connected',
                        'last_sync_at' => now(),
                    ]
                );
                return response()->json(['status' => 'success']);
            }
        }

        // 2. Handle user redirect (GET)
        // If it's just the user redirect without data yet (return_url)
        return redirect()->route('automation.integrations.show', 'woocommerce')
            ->with('success', 'WooCommerce store connected successfully!');
    }
}
