<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function sales()
    {
        return view('reports.sales');
    }

    public function purchases()
    {
        return view('reports.purchases');
    }

    public function inventory()
    {
        return view('reports.inventory');
    }

    public function integrations()
    {
        return view('reports.integrations');
    }

    public function financials()
    {
        return view('reports.financials');
    }

    public function returns()
    {
        return view('reports.returns');
    }
}
