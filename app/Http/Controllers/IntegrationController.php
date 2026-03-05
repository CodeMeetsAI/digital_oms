<?php

namespace App\Http\Controllers;

use App\Models\UserIntegration;
use App\Models\Integration;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    protected $platforms = [
        'woocommerce' => [
            'name' => 'WooCommerce',
            'slug' => 'woocommerce',
            'logo' => 'https://img.icons8.com/color/96/000000/woocommerce.png',
            'description' => 'Connect your WordPress-based store to sync products and orders.',
        ],
        'shopify' => [
            'name' => 'Shopify',
            'slug' => 'shopify',
            'logo' => 'https://img.icons8.com/color/96/000000/shopify.png',
            'description' => 'Integrate your Shopify store via Admin Access Token.',
        ],
        'daraz' => [
            'name' => 'Daraz',
            'slug' => 'daraz',
            'logo' => 'https://img.icons8.com/color/96/000000/daraz.png',
            'description' => 'Link your Daraz seller account to manage local inventory.',
        ],
        'wordpress' => [
            'name' => 'WordPress',
            'slug' => 'wordpress',
            'logo' => 'https://img.icons8.com/color/96/000000/wordpress.png',
            'description' => 'Standard WordPress integration for blog or custom content.',
        ],
    ];

    protected $platformToSlug = [
        'woocommerce' => 'woo',
        'daraz'       => 'daraz',
        'shopify'     => 'shopify',
        'leopard'     => 'leopard',
    ];

    public function showIntegrationsPage()
    {
        $connectedIntegrationIds = UserIntegration::where('user_id', auth()->id())
            ->pluck('integration_id')
            ->toArray();

        $connectedPlatforms = [];
        foreach ($this->platformToSlug as $uiSlug => $dbSlug) {
            $int = Integration::where('slug', $dbSlug)->orWhere('slug', $uiSlug)->first();
            if ($int && in_array($int->id, $connectedIntegrationIds)) {
                $connectedPlatforms[] = $uiSlug;
            }
        }

        return view('integrations.index', [
            'platforms' => $this->platforms,
            'connectedPlatforms' => $connectedPlatforms
        ]);
    }

    public function showPlatformConfig($platform)
    {
        if (!isset($this->platforms[$platform])) {
            abort(404, "Platform configuration for '$platform' not found.");
        }

        $config = $this->platforms[$platform];
        $dbSlug = $this->platformToSlug[$platform] ?? $platform;

        $integration = Integration::where('slug', $dbSlug)
            ->orWhere('slug', $platform)
            ->first();

        if (!$integration) {
            abort(404, "Integration '$dbSlug' not found in database.");
        }

        $existing = UserIntegration::where('integration_id', $integration->id)
            ->where('user_id', auth()->id())
            ->first();

        return view('integrations.platform', compact('config', 'existing', 'platform'));
    }

    public function connectAccount(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string',
            'store_nickname' => 'required|string|max:255',
            'store_url' => 'required|url',
            'api_key' => 'required|string',
            'secret_key' => 'nullable|string',
            'fetch_products' => 'boolean',
            'auto_import_orders' => 'boolean',
            'sync_stock' => 'boolean',
            'update_product' => 'boolean',
            'push_fulfillment' => 'boolean',
        ]);

        $dbSlug = $this->platformToSlug[$validated['platform']] ?? $validated['platform'];

        $integration = Integration::where('slug', $dbSlug)
            ->orWhere('slug', $validated['platform'])
            ->first();

        if (!$integration) {
            return response()->json([
                'success' => false,
                'message' => "Platform integration '$dbSlug' not found in database."
            ], 404);
        }

        // ✅ Important: Do not cast api_key/api_secret as encrypted here, send as plain TEXT
        $userIntegration = UserIntegration::updateOrCreate(
            [
                'integration_id' => $integration->id,
                'user_id' => auth()->id(),
            ],
            [
                'platform' => $validated['platform'],
                'store_nickname' => $validated['store_nickname'],
                'store_name' => $validated['store_nickname'],
                'store_url' => $validated['store_url'],
                'api_key' => $validated['api_key'],        // plain text
                'api_secret' => $validated['secret_key'] ?? null, // plain text
                'auto_import_orders' => $request->boolean('auto_import_orders'),
                'sync_stock' => $request->boolean('sync_stock'),
                'update_product' => $request->boolean('update_product'),
                'push_fulfillment' => $request->boolean('push_fulfillment'),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Account ' . $validated['store_nickname'] . ' connected successfully!',
            'data' => $userIntegration
        ]);
    }
}