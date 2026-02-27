<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Automation; // Abhi create karenge model

class AutomationController extends Controller
{
    public function index()
    {
        $automations = Automation::all(); // DB se saare automation rules fetch karenge
        return view('automation.index', compact('automations'));
    }
}