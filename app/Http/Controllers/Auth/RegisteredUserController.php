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

        // ✅ Create the user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // ✅ Create tenant DB & run migrations safely
        $this->setupTenantDatabase($user);

        // ✅ Logout the user (optional, if you want them to login manually)
        Auth::logout();

        // ✅ Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Account created successfully! Please login.');
    }

    /**
     * Setup tenant database safely
     */
    protected function setupTenantDatabase(User $user)
    {
        // Example: check if table exists before creating
        if (!Schema::hasTable('woo_integrations')) {
            Schema::create('woo_integrations', function ($table) {
                $table->id();
                $table->string('store_nickname');
                $table->string('contact_number')->nullable();
                $table->string('email')->nullable();
                $table->string('store_image')->nullable();
                $table->string('api_url');
                $table->string('consumer_key');
                $table->string('consumer_secret');
                $table->boolean('push_fulfillment')->default(0);
                $table->boolean('auto_import_orders')->default(0);
                $table->string('customer_category')->nullable();
                $table->boolean('take_stock_mode')->default(0);
                $table->string('take_stock_location')->nullable();
                $table->boolean('update_price')->default(0);
                $table->boolean('auto_import_products')->default(0);
                $table->boolean('sync_stock')->default(0);
                $table->boolean('update_product_on_import')->default(0);
                $table->boolean('auto_generate_sku')->default(0);
                $table->timestamps();
            });
        }

        // ✅ Optionally, run other tenant-specific migrations here
        // Artisan::call('tenants:migrate', ['--tenants' => [$user->id]]);
    }
}