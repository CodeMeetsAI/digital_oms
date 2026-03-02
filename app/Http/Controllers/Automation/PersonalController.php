<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function details() { return view('automation.placeholder', ['title' => 'Personal Details']); }
    public function defaultDetails() { return view('automation.placeholder', ['title' => 'Default Details']); }
    public function passwordDetails() { return view('automation.placeholder', ['title' => 'Password Details']); }
}
