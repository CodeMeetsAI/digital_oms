<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntegrationController extends Controller
{
    // Mapping of slug to database table
    private $integrationTables = [
        'daraz' => 'daraz_integrations',
        'woo' => 'woo_integrations',
        'leopard' => 'leopards_integrations',
    ];

    public function show($slug)
    {
        if (!isset($this->integrationTables[$slug])) {
            abort(404, "Integration not found.");
        }

        $table = $this->integrationTables[$slug];

        // Fetch the first row (or whatever logic you need)
        $integrationData = DB::table($table)->first();

        return view('integrations.show', [
            'slug' => $slug,
            'integrationData' => $integrationData
        ]);
    }

    public function store(Request $request, $slug)
    {
        if (!isset($this->integrationTables[$slug])) {
            abort(404, "Integration not found.");
        }

        $table = $this->integrationTables[$slug];

        $data = $request->validate([
            'store_nickname' => 'nullable|string|max:255',
            'store_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
        ]);

        // If you have user-specific integration, you can use user_id here
        $data['updated_at'] = now();

        // Insert or update logic
        $existing = DB::table($table)->first();
        if ($existing) {
            DB::table($table)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table($table)->insert($data);
        }

        return redirect()->back()->with('success', 'Integration saved successfully.');
    }
}