<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DarazIntegration;

class DarazController extends Controller
{
    public function index()
    {
        $data = DarazIntegration::all();
        return view('daraz.index', compact('data'));
    }

    public function store(Request $request)
    {
        DarazIntegration::create($request->all());
        return back()->with('success', 'Saved Successfully');
    }
}