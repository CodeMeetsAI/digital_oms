<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Show the templates dashboard.
     */
    public function index()
    {
        return view('template.index');
    }

    /**
     * Show the template creation form.
     */
    public function create()
    {
        return view('template.create');
    }

    /**
     * Show the template edit form.
     */
    public function edit($id)
    {
        $template = Template::findOrFail($id);
        return view('template.edit', compact('template'));
    }

    /**
     * Show the template view.
     */
    public function show($id)
    {
        $template = Template::findOrFail($id);
        return view('template.show', compact('template'));
    }
}
