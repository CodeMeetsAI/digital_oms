<?php

use App\Http\Controllers\Central\DomainFinderController;
use App\Http\Controllers\Tenancy\RegistrationController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\WooIntegrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Central domains (tenants) + local testing routes for integrations
|
*/

// ------------------------------
// 1️⃣ Tenant Domain Routes
// ------------------------------
foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        // Home & Domain Redirect
        Route::get('/', [DomainFinderController::class, 'index'])->name('home');
        Route::post('/domain-redirect', [DomainFinderController::class, 'redirect'])->name('domain.redirect');

        // User Registration
        Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegistrationController::class, 'register']);

        // Daraz integration example
        Route::get('/daraz', [App\Http\Controllers\DarazController::class, 'index']);
        Route::post('/daraz', [App\Http\Controllers\DarazController::class, 'store']);

        // Dashboard route example (tenant-specific)
        Route::get('/dashboard', [App\Http\Controllers\Dashboards\DashboardController::class, 'index'])
            ->middleware(['auth'])
            ->name('dashboard');

        // WooCommerce Integration Routes (tenant domain)
        Route::get('/woo-integration-create', [WooIntegrationController::class, 'create'])->name('woo.integration.create');
        Route::post('/woo-integration-store', [WooIntegrationController::class, 'store'])->name('woo.integration.store');
        Route::get('/woo-sync-products/{id}', [WooIntegrationController::class, 'syncProducts'])->name('woo.sync.products');
        Route::get('/woo-sync-orders/{id}', [WooIntegrationController::class, 'syncOrders'])->name('woo.sync.orders');

        // Other tenant-specific integrations
        Route::get('/integrations/{slug}', [IntegrationController::class, 'show'])->name('integrations.show');
        Route::post('/integrations/{slug}', [IntegrationController::class, 'store'])->name('integrations.store');
    });
}

// ------------------------------
// 2️⃣ Local Testing / Fallback Routes
// ------------------------------
Route::prefix('local')->group(function () {

    // WooCommerce Integration Routes (local testing)
    Route::get('/woo-integration-create', [WooIntegrationController::class, 'create'])->name('woo.integration.create.local');
    Route::post('/woo-integration-store', [WooIntegrationController::class, 'store'])->name('woo.integration.store.local');
    Route::get('/woo-sync-products/{id}', [WooIntegrationController::class, 'syncProducts'])->name('woo.sync.products.local');
    Route::get('/woo-sync-orders/{id}', [WooIntegrationController::class, 'syncOrders'])->name('woo.sync.orders.local');

    // Integrations (local testing)
    Route::get('/integrations/{slug}', [IntegrationController::class, 'show'])->name('integrations.show.local');
    Route::post('/integrations/{slug}', [IntegrationController::class, 'store'])->name('integrations.store.local');

    // Dashboard fallback (local testing)
    Route::get('/dashboard', [App\Http\Controllers\Dashboards\DashboardController::class, 'index'])
        ->middleware(['auth'])
        ->name('dashboard.local');
});

// ------------------------------
// 3️⃣ Optional Default Fallback (any domain / unmatched)
// ------------------------------
Route::get('/integrations/{slug}', [IntegrationController::class, 'show'])->name('integrations.show.default');
Route::post('/integrations/{slug}', [IntegrationController::class, 'store'])->name('integrations.store.default');

// WooCommerce Integration Fallback (global)
Route::get('/woo-integration-create', [WooIntegrationController::class, 'create'])->name('woo.integration.create.default');
Route::post('/woo-integration-store', [WooIntegrationController::class, 'store'])->name('woo.integration.store.default');
Route::get('/woo-sync-products/{id}', [WooIntegrationController::class, 'syncProducts'])->name('woo.sync.products.default');
Route::get('/woo-sync-orders/{id}', [WooIntegrationController::class, 'syncOrders'])->name('woo.sync.orders.default');  