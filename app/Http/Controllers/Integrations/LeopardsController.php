<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use App\Models\LeopardsIntegration;
use Illuminate\Http\Request;

class LeopardsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_nickname' => ['required', 'string', 'max:255'],
            'courier_company' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'support_no' => ['nullable', 'string', 'max:50'],
            'landline_no' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'account_no' => ['nullable', 'string', 'max:100'],
            'shipper_id' => ['nullable', 'string', 'max:100'],
            'api_key' => ['required', 'string'],
            'api_password' => ['required', 'string'],
            'default_weight' => ['nullable', 'string', 'max:50'],
            'default_note' => ['nullable', 'string'],
        ]);

        $data = $validated;

        $data['auto_sync_fulfillment'] = (bool) $request->boolean('auto_sync_fulfillment');
        $data['set_product_details_remarks'] = (bool) $request->boolean('set_product_details_remarks');
        $data['set_product_details_label'] = (bool) $request->boolean('set_product_details_label');
        $data['allow_open_shipment'] = (bool) $request->boolean('allow_open_shipment');

        $integration = LeopardsIntegration::query()->first();
        if ($integration) {
            $integration->update($data);
        } else {
            $integration = LeopardsIntegration::create($data);
        }

        return redirect()->back()->with('success', 'Leopards courier settings saved.');
    }

    public function test(Request $request)
    {
        $request->validate([
            'account_nickname' => ['nullable', 'string', 'max:255'],
            'api_key' => ['required', 'string'],
            'api_password' => ['required', 'string'],
            'shipper_id' => ['nullable', 'string', 'max:100'],
        ]);

        return response()->json([
            'ok' => true,
            'status' => 200,
        ]);
    }
}
