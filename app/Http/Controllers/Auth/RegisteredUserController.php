<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // ✅ Validate incoming data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class, 'alpha_dash:ascii'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms-of-service' => ['required'],
        ]);

        // ✅ Step 1: Create the Tenant
        $tenantId = strtolower($request->username);
        $tenant = \App\Models\Tenant::create([
            'id' => $tenantId,
            'name' => $request->name,
            'subdomain' => $tenantId,
        ]);

        // ✅ Step 2: Create the Domain (subdomain.base-domain.com)
        // You can adjust the base domain as needed
        $baseDomain = parse_url(config('app.url'), PHP_URL_HOST) ?: 'localhost';
        $tenant->domains()->create([
            'domain' => $tenantId . '.' . $baseDomain,
        ]);

        // ✅ Step 3: Create the User and link to the Tenant
        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // ✅ Logout (optional, if you want them to login manually)
        Auth::logout();

        // ✅ Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Account created successfully! Please login.');
    }
}