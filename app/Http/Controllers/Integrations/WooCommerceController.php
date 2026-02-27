<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use App\Models\WooIntegration;
use App\Services\WooCommerceClient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WooCommerceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_nickname' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email'],
            'store_image' => ['nullable', 'file', 'image', 'max:2048'],
            'api_url' => ['required', 'url'],
            'consumer_key' => ['required', 'string'],
            'consumer_secret' => ['required', 'string'],
            'customer_category' => ['nullable'],
            'take_stock_mode' => ['nullable', Rule::in(['all', 'specific'])],
            'take_stock_location' => ['nullable', 'string', 'max:255'],
        ]);

        $data = $validated;

        $data['push_fulfillment'] = (bool) $request->boolean('push_fulfillment');
        $data['auto_import_orders'] = (bool) $request->boolean('auto_import_orders');
        $data['update_price'] = (bool) $request->boolean('update_price');
        $data['auto_import_products'] = (bool) $request->boolean('auto_import_products');
        $data['sync_stock'] = (bool) $request->boolean('sync_stock');
        $data['update_product_on_import'] = (bool) $request->boolean('update_product_on_import');
        $data['auto_generate_sku'] = (bool) $request->boolean('auto_generate_sku');

        if ($request->hasFile('store_image')) {
            $path = $request->file('store_image')->store('stores', 'public');
            $data['store_image'] = $path;
        }

        $integration = WooIntegration::query()->first();
        if ($integration) {
            $integration->update($data);
        } else {
            $integration = WooIntegration::create($data);
        }

        return redirect()->back()->with('success', 'WooCommerce settings saved.');
    }

    public function test(Request $request, WooCommerceClient $client)
    {
        $request->validate([
            'api_url' => ['required', 'url'],
            'consumer_key' => ['required', 'string'],
            'consumer_secret' => ['required', 'string'],
        ]);

        $result = $client->test($request->input('api_url'), $request->input('consumer_key'), $request->input('consumer_secret'));

        return response()->json($result);
    }
}
