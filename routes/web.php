<?php

use App\Http\Controllers\Central\DomainFinderController;
use App\Http\Controllers\Tenancy\RegistrationController;
use App\Http\Controllers\IntegrationController;
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
        
        Route::get('/daraz', [App\Http\Controllers\DarazController::class, 'index']);
Route::post('/daraz', [App\Http\Controllers\DarazController::class, 'store']);

        Route::get('/integrations/{slug}', [IntegrationController::class, 'show'])->name('integrations.show'); 


        // Integrations Routes (tenant domain)
        Route::get('/integrations/{slug}', [IntegrationController::class, 'show'])
            ->name('integrations.show');
        Route::post('/integrations/{slug}', [IntegrationController::class, 'store'])
            ->name('integrations.store');

        // Dashboard route example (tenant-specific)
        Route::get('/dashboard', [App\Http\Controllers\Dashboards\DashboardController::class, 'index'])
            ->middleware(['auth'])
            ->name('dashboard');
    });
}

// ------------------------------
// 2️⃣ Local Testing / Fallback Routes
// ------------------------------
Route::prefix('local')->group(function () {
    // Integrations (local testing)
    Route::get('/integrations/{slug}', [IntegrationController::class, 'show'])
        ->name('integrations.show.local');
    Route::post('/integrations/{slug}', [IntegrationController::class, 'store'])
        ->name('integrations.store.local');

    // Dashboard fallback (local testing)
    Route::get('/dashboard', [App\Http\Controllers\Dashboards\DashboardController::class, 'index'])
        ->middleware(['auth'])
        ->name('dashboard.local');
});
// Integration routes (local/testing + central)
Route::get('/integrations/{slug}', [IntegrationController::class, 'show'])
    ->name('integrations.show');
Route::post('/integrations/{slug}', [IntegrationController::class, 'store'])
    ->name('integrations.store');

// ------------------------------
// 3️⃣ Optional Default Fallback (any domain / unmatched)
// ------------------------------
Route::get('/integrations/{slug}', [IntegrationController::class, 'show'])
    ->name('integrations.show.default');
Route::post('/integrations/{slug}', [IntegrationController::class, 'store'])
    ->name('integrations.store.default');