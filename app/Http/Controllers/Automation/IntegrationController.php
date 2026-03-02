<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use App\Models\Integration;
use App\Models\UserIntegration;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    public function index()
    {
        $integrations = Integration::all();
        return view('automation.integrations.index', compact('integrations'));
    }

    /**
     * Show the integration setup page.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        // 1. Ensure the integration model exists or create a placeholder
        $integration = Integration::firstOrCreate(
            ['slug' => $slug],
            ['name' => ucfirst($slug)]
        );

        // 2. Load existing integration settings for this tenant
        $userIntegration = UserIntegration::where('integration_id', $integration->id)->first();
        
        // 3. Pass slug, integration model, and settings to the view
        return view('automation.integrations.show', compact('slug', 'integration', 'userIntegration'));
    }

    public function store(Request $request, $slug)
    {
        $integration = Integration::firstOrCreate(
            ['slug' => $slug],
            ['name' => ucfirst($slug)]
        );
        
        $validated = $request->validate([
            'store_url' => 'required|url',
            'api_key' => 'required|string',
            'api_secret' => 'nullable|string',
            'username' => 'nullable|string',
            'password' => 'nullable|string',
        ]);

        UserIntegration::updateOrCreate(
            ['integration_id' => $integration->id],
            [
                'api_key' => $validated['api_key'],
                'api_secret' => $validated['api_secret'],
                'store_url' => $validated['store_url'],
                'status' => 'active',
            ]
        );

        return back()->with('success', ucfirst($slug) . ' integration connected successfully!');
    }
}
