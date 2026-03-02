<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function shipping() { return view('automation.placeholder', ['title' => 'Shipping']); }
    public function locations() { return view('automation.placeholder', ['title' => 'Locations']); }
    public function categories() { return view('automation.placeholder', ['title' => 'Categories']); }
    public function variations() { return view('automation.placeholder', ['title' => 'Variations']); }
    public function barcodes() { return view('automation.placeholder', ['title' => 'Barcodes']); }
    public function priceList() { return view('automation.placeholder', ['title' => 'Price List']); }
    public function financials() { return view('automation.placeholder', ['title' => 'Financials']); }
    public function taxes() { return view('automation.placeholder', ['title' => 'Taxes']); }
    public function salesProcess() { return view('automation.placeholder', ['title' => 'Sales Process']); }
    public function transactionNumbers() { return view('automation.placeholder', ['title' => 'Transaction Numbers']); }
    public function automations() { return view('automation.placeholder', ['title' => 'Automations']); }
    public function paymentMethods() { return view('automation.placeholder', ['title' => 'Payment Methods']); }
    public function shippingMethods() { return view('automation.placeholder', ['title' => 'Shipping Methods']); }
    public function tags() { return view('automation.placeholder', ['title' => 'Tags']); }
    public function brands() { return view('automation.placeholder', ['title' => 'Brands']); }
    public function returnManagement() { return view('automation.placeholder', ['title' => 'Return Management']); }
}
