<?php

namespace App\Http\Controllers\Tenancy;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        $centralDomain = config('tenancy.central_domains')[0] ?? 'localhost';
        $currentHost = request()->getHost();

        if (in_array($currentHost, config('tenancy.central_domains'))) {
            $centralDomain = $currentHost;
        }

        return view('central.register', ['centralDomain' => $centralDomain]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $tenantId = Str::slug($request->company_name);

        if (Tenant::find($tenantId)) {
            return back()->withErrors(['company_name' => 'Company name already taken.']);
        }

        $centralConnection = config('tenancy.database.central_connection', config('database.default'));
        $prefix = config('tenancy.database.prefix', 'tenant');
        $suffix = config('tenancy.database.suffix', '');
        $databaseName = $prefix.$tenantId.$suffix;

        $databaseExists = false;
        $driver = config("database.connections.{$centralConnection}.driver");

        if ($driver === 'mysql') {
            $databaseExists = (bool) DB::connection($centralConnection)
                ->selectOne('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?', [$databaseName]);
        }

        if ($databaseExists) {
            $tenant = Tenant::withoutEvents(function () use ($tenantId, $request) {
                return Tenant::create([
                    'id' => $tenantId,
                    'company_name' => $request->company_name,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);
            });
        } else {
            $tenant = Tenant::create([
                'id' => $tenantId,
                'company_name' => $request->company_name,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        }

        $centralDomain = config('tenancy.central_domains')[0] ?? 'localhost';

        // Use current host if it's a valid central domain (not IP)
        $currentHost = request()->getHost();
        if (in_array($currentHost, config('tenancy.central_domains')) && ! preg_match('/^\d+\.\d+\.\d+\.\d+$/', $currentHost)) {
            $centralDomain = $currentHost;
        }

        $domain = $tenantId.'.'.$centralDomain;

        $tenant->domains()->firstOrCreate([
            'domain' => $domain,
        ]);

        if ($databaseExists) {
            $tenant->run(function () {
                Artisan::call('migrate', [
                    '--path' => database_path('migrations/tenant'),
                    '--force' => true,
                ]);
            });
        }

        $tenant->run(function () use ($request) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->email, // Using email as username initially
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
            ]);
        });

        $protocol = request()->secure() ? 'https://' : 'http://';
        $port = request()->getPort();
        $portSuffix = ($port && $port != 80 && $port != 443) ? ':'.$port : '';

        return redirect($protocol.$domain.$portSuffix.'/login');
    }
}
