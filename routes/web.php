<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Central\DomainFinderController;
use App\Http\Controllers\Tenancy\RegistrationController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\WooIntegrationController;
use App\Http\Controllers\Order\OrderController;
// use App\Http\Controllers\Order\OrderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
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

        // Dashboard (tenant-specific)
        Route::get('/dashboard', [App\Http\Controllers\Dashboards\DashboardController::class, 'index'])
            ->middleware(['auth'])
            ->name('dashboard');

        // WooCommerce Integration Routes
        Route::get('/woo-integration-create', [WooIntegrationController::class, 'create'])->name('woo.integration.create');
        Route::post('/woo-integration-store', [WooIntegrationController::class, 'store'])->name('woo.integration.store');
        Route::get('/woo-sync-products/{id}', [WooIntegrationController::class, 'syncProducts'])->name('woo.sync.products');
        Route::get('/woo-sync-orders/{id}', [WooIntegrationController::class, 'syncOrders'])->name('woo.sync.orders');

        // Orders Routes
        Route::prefix('orders')->middleware(['auth'])->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::post('/sync', [OrderController::class, 'sync'])->name('sync');
        //  use App\Http\Controllers\Order\OrderController;

Route::get('/pick-list', [OrderController::class, 'pickListIndex'])->name('picklist.index');
Route::post('/pick-list/{orderId}/priority', [OrderController::class, 'updatePickPriority'])->name('picklist.priority');
Route::post('/pick-list/{orderId}/assign', [OrderController::class, 'updatePickAssignedUser'])->name('picklist.assign');
Route::post('/pick-list/{orderId}/progress', [OrderController::class, 'updatePickProgress'])->name('picklist.progress');
            Route::get('/packing-list/{id}', [OrderController::class, 'packingList'])->name('packing-list');
            Route::get('/invoice/{id}', [OrderController::class, 'invoice'])->name('invoice');

            // Optional Bulk Actions
            Route::get('/bulk-picklist', [OrderController::class, 'bulkPickList'])->name('bulk-picklist');
            Route::get('/bulk-packing-list', [OrderController::class, 'bulkPackingList'])->name('bulk-packing-list');
            Route::get('/bulk-invoice', [OrderController::class, 'bulkInvoice'])->name('bulk-invoice');
        });

        // Other tenant integrations
        Route::get('/integrations/{slug}', [IntegrationController::class, 'show'])->name('integrations.show');
        Route::post('/integrations/{slug}', [IntegrationController::class, 'store'])->name('integrations.store');
    });
}

// ------------------------------
// 2️⃣ Local Testing / Fallback Routes
// ------------------------------
Route::prefix('orders')->middleware(['auth'])->name('orders.')->group(function () {

    Route::get('/', [OrderController::class, 'index'])->name('index');

    Route::post('/sync', [OrderController::class, 'sync'])->name('sync');

   Route::get('/orders/{orderId}/pick-list', [OrderController::class, 'generatePickList'])->name('orders.picklist');

    Route::get('/packing-list/{id}', [OrderController::class, 'packingList'])->name('packing-list');

    Route::get('/invoice/{id}', [OrderController::class, 'generateInvoice'])->name('invoice');

});

Route::middleware(['auth'])->group(function () {

    // WooCommerce Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/sync', [OrderController::class, 'sync'])->name('orders.sync');

    // Pick List
   

Route::get('/pick-list', [OrderController::class, 'pickListIndex'])->name('picklist.index');
Route::post('/pick-list/{orderId}/priority', [OrderController::class, 'updatePickPriority'])->name('picklist.priority');
Route::post('/pick-list/{orderId}/assign', [OrderController::class, 'updatePickAssignedUser'])->name('picklist.assign');
Route::post('/pick-list/{orderId}/progress', [OrderController::class, 'updatePickProgress'])->name('picklist.progress');
Route::get('/orders/{orderId}/pick-list', [OrderController::class, 'generatePickList'])->name('orders.picklist');
    // Packing List
    Route::get('/orders/{order}/packing-list', [OrderController::class, 'packingList'])
        ->name('orders.packinglist');

    // Agar invoice ka bhi route chahiye
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])
        ->name('orders.invoice');

    Route::post('/orders/{orderId}/resync-details', [OrderController::class, 'resyncSingleOrderDetails'])
    ->name('orders.resyncDetails');
});
    // Integrations (local)
    Route::get('/integrations/{slug}', [IntegrationController::class, 'show'])->name('integrations.show.local');
    Route::post('/integrations/{slug}', [IntegrationController::class, 'store'])->name('integrations.store.local');



// use App\Http\Controllers\Order\OrderController;

Route::middleware(['auth'])->group(function () {

    // WooCommerce Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/sync', [OrderController::class, 'sync'])->name('orders.sync');

    // Pick List
    Route::get('/orders/{order}/pick-list', [OrderController::class, 'generatePickList'])
        ->name('orders.picklist');

    // Packing List
    Route::get('/packing-list/{id}', [OrderController::class, 'packingList'])->name('packing-list.local');
        Route::get('/invoice/{id}', [OrderController::class, 'invoice'])->name('invoice.local');
});
// ------------------------------
// 3️⃣ Optional Global Fallback Routes
// ------------------------------
Route::fallback(function () {
    return redirect()->route('orders.index');
});