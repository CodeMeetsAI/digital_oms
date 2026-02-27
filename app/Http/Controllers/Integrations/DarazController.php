<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use App\Models\DarazIntegration;
use App\Services\DarazClient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DarazController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_nickname' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email'],
            'store_image' => ['nullable', 'file', 'image', 'max:2048'],
            'api_url' => ['required', 'url'],
            'api_secret' => ['required', 'string'],
            'api_key' => ['required', 'string'],
            'customer_category' => ['nullable'],
            'take_stock_mode' => ['nullable', Rule::in(['all', 'specific'])],
            'take_stock_location' => ['nullable', 'string', 'max:255'],
            'fulfill_fbd_location' => ['nullable', 'string', 'max:255'],
        ]);

        $data = $validated;

        $data['push_fulfillment'] = (bool) $request->boolean('push_fulfillment');
        $data['pull_delivery_status'] = (bool) $request->boolean('pull_delivery_status');
        $data['sync_stock'] = (bool) $request->boolean('sync_stock');
        $data['auto_import_orders'] = (bool) $request->boolean('auto_import_orders');
        $data['update_price'] = (bool) $request->boolean('update_price');
        $data['auto_import_products'] = (bool) $request->boolean('auto_import_products');
        $data['update_product_on_import'] = (bool) $request->boolean('update_product_on_import');
        $data['auto_generate_sku'] = (bool) $request->boolean('auto_generate_sku');

        if ($request->hasFile('store_image')) {
            $path = $request->file('store_image')->store('stores', 'public');
            $data['store_image'] = $path;
        }

        $integration = DarazIntegration::query()->first();
        if ($integration) {
            $integration->update($data);
        } else {
            $integration = DarazIntegration::create($data);
        }

        return redirect()->back()->with('success', 'Daraz settings saved.');
    }

    public function test(Request $request, DarazClient $client)
    {
        $request->validate([
            'api_url' => ['required', 'url'],
            'api_key' => ['required', 'string'],
            'api_secret' => ['required', 'string'],
        ]);

        $result = $client->test($request->input('api_url'), $request->input('api_key'), $request->input('api_secret'));

        return response()->json($result);
    }
}
