<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function details() { return view('automation.placeholder', ['title' => 'Company Details']); }
    public function teamMembers() { return view('automation.placeholder', ['title' => 'Team Members']); }
    public function notifications() { return view('automation.placeholder', ['title' => 'Notification Settings']); }
    public function roles() { return view('automation.placeholder', ['title' => 'Role Management']); }
}
