<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class DomainFinderController extends Controller
{
    public function index(Request $request)
    {
        $host = $request->getHost();
        $centralDomains = config('tenancy.central_domains');
        $currentDomain = $centralDomains[0];

        foreach ($centralDomains as $domain) {
            if (str_contains($host, $domain)) {
                $currentDomain = $domain;
                break;
            }
        }

        // Fix for 127.0.0.1 which doesn't support subdomains
        if ($currentDomain === '127.0.0.1') {
            $currentDomain = 'localhost';
        }

        return view('central.domain-finder', ['centralDomain' => $currentDomain]);
    }

    public function redirect(Request $request)
    {
        $request->validate([
            'domain' => 'required|string',
        ]);

        $domain = $request->input('domain');

        // Check if tenant exists (optional but good for UX)
        // Assuming the tenant ID is the subdomain
        $tenant = Tenant::find($domain);

        if (! $tenant) {
            return back()->withErrors(['domain' => 'We couldn\'t find a store with that name.']);
        }

        // Construct the URL
        // We need to know the central domain structure.
        // If the central domain is 'localhost', the tenant url is 'domain.localhost:8000'
        // If the central domain is 'oms.test', the tenant url is 'domain.oms.test'

        $centralDomain = config('tenancy.central_domains')[0]; // Pick the first one or logic to pick current

        // For local development with ports (e.g. localhost:8000), we need to be careful.
        // Ideally, we should construct it based on the current request's host if it matches a central domain.

        $host = $request->getHost();
        $port = $request->getPort();
        $portString = ($port && $port != 80 && $port != 443) ? ":$port" : '';

        // If we are on localhost, we append the domain as a subdomain.
        // However, usually on localhost, we might be using 'domain.localhost'

        // Let's assume the user enters 'xanas' and we want 'http://xanas.localhost:8000'

        // We can strip 'www.' if present from the current host to get the base central domain.
        // But simply, we can just use the config or the current host.

        // If the current host is '127.0.0.1', subdomains might not work easily without /etc/hosts.
        // If the current host is 'localhost', 'xanas.localhost' works.

        // Let's try to be smart about the protocol.
        $protocol = $request->secure() ? 'https://' : 'http://';

        $redirectUrl = $protocol.$domain.'.'.$centralDomain.$portString.'/login';

        // If the current request host is in the central domains list, use it as the base.
        foreach (config('tenancy.central_domains') as $cd) {
            if (str_contains($host, $cd)) {
                $targetDomain = $cd;
                // Fix for 127.0.0.1 which doesn't support subdomains
                if ($targetDomain === '127.0.0.1') {
                    $targetDomain = 'localhost';
                }
                $redirectUrl = $protocol.$domain.'.'.$targetDomain.$portString.'/login';
                break;
            }
        }

        return redirect()->away($redirectUrl);
    }
}
