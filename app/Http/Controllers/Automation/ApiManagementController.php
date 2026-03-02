<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiManagementController extends Controller
{
    public function index()
    {
        $apiKeys = ApiKey::all();
        return view('automation.api-management.index', compact('apiKeys'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ApiKey::create([
            'name' => $request->name,
            'api_key' => 'oms_' . Str::random(40),
            'tenant_id' => tenant('id'), // stancl/tenancy
        ]);

        return back()->with('success', 'API key generated successfully!');
    }

    public function revoke($id)
    {
        $apiKey = ApiKey::findOrFail($id);
        $apiKey->delete();

        return back()->with('success', 'API key revoked successfully!');
    }
}
