<?php

namespace App\Http\Controllers;

use App\Models\UserIntegration;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    /**
     * Dashboard for all integrations.
     */
    public function index()
    {
        return view('integrations.index');
    }

    /**
     * Create new integration.
     */
    public function create()
    {
        return view('integrations.create');
    }

    /**
     * Edit integration.
     */
    public function edit($id)
    {
        $integration = UserIntegration::findOrFail($id);
        return view('integrations.edit', compact('integration'));
    }

    /**
     * View integration details.
     */
    public function show($id)
    {
        $integration = UserIntegration::findOrFail($id);
        return view('integrations.show', compact('integration'));
    }
}
