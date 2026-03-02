<?php

declare(strict_types=1);
use App\Http\Controllers\Automation\AutomationController;
use App\Http\Controllers\Automation\PersonalController;
use App\Http\Controllers\Automation\CompanyController;
use App\Http\Controllers\Automation\ConfigurationController;
use App\Http\Controllers\Automation\IntegrationController as AutomationIntegrationController;
use App\Http\Controllers\Automation\ApiManagementController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Dashboards\DashboardController;
use App\Http\Controllers\Financials\ChartOfAccountController;
use App\Http\Controllers\Integrations\DarazController;
use App\Http\Controllers\Integrations\LeopardsController;
use App\Http\Controllers\Integrations\WooCommerceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Order\DueOrderController;
use App\Http\Controllers\Order\OrderCompleteController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\OrderPendingController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductExportController;
use App\Http\Controllers\Product\ProductImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Quotation\QuotationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Integrations\WooCommerceOAuthController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('php/', function () {
        return phpinfo();
    });

    Route::get('/', function () {
        return redirect()->route('login');
    });

    require __DIR__.'/auth.php';

    Route::middleware(['auth'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile Photo Route
        Route::get('/profile-photo/{filename}', [ProfileController::class, 'photo'])->name('profile.photo');

        // User Management
        Route::resource('/users', UserController::class); // ->except(['show']);
        Route::put('/user/change-password/{username}', [UserController::class, 'updatePassword'])->name('users.updatePassword');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::resource('/quotations', QuotationController::class);
        Route::resource('/customers', CustomerController::class);
        Route::get('/customer-categories', [CustomerController::class, 'customerCategoryIndex'])->name('customer-categories.index');
        Route::post('/customer-categories', [CustomerController::class, 'customerCategoryStore'])->name('customer-categories.store');
        Route::delete('/customer-categories/{customerCategory}', [CustomerController::class, 'customerCategoryDestroy'])->name('customer-categories.destroy');
        Route::resource('/suppliers', SupplierController::class);
        Route::get('/supplier-categories', [SupplierController::class, 'supplierCategoryIndex'])->name('supplier-categories.index');
        Route::post('/supplier-categories', [SupplierController::class, 'supplierCategoryStore'])->name('supplier-categories.store');
        Route::delete('/supplier-categories/{supplierCategory}', [SupplierController::class, 'supplierCategoryDestroy'])->name('supplier-categories.destroy');
        Route::resource('/categories', CategoryController::class);
        Route::resource('/units', UnitController::class);

        // Financials
        Route::get('/chart-of-accounts', [ChartOfAccountController::class, 'index'])->name('financials.chart-of-accounts');
        Route::post('/chart-of-accounts', [ChartOfAccountController::class, 'store'])->name('financials.chart-of-accounts.store');
        Route::put('/chart-of-accounts/{id}', [ChartOfAccountController::class, 'update'])->name('financials.chart-of-accounts.update');
        Route::delete('/chart-of-accounts/{id}', [ChartOfAccountController::class, 'destroy'])->name('financials.chart-of-accounts.destroy');

        // Livewire Tenant Fix
        Route::post('livewire/update', [Livewire\Mechanisms\HandleRequests\HandleRequests::class, 'handle'])->name('livewire.update');

        // Route Products
        Route::get('/products/import', [ProductImportController::class, 'create'])->name('products.import.view');
        Route::post('/products/import', [ProductImportController::class, 'store'])->name('products.import.store');
        Route::get('/products/export', [ProductExportController::class, 'create'])->name('products.export.store');
        Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
        Route::post('/products/bundle', [ProductController::class, 'storeBundle'])->name('products.bundle.store');
        Route::resource('/products', ProductController::class);

        // Route Purchases
        Route::get('/purchases/approved', [PurchaseController::class, 'approvedPurchases'])->name('purchases.approvedPurchases');
        Route::get('/purchases/report', [PurchaseController::class, 'dailyPurchaseReport'])->name('purchases.dailyPurchaseReport'); // Check if this method exists, if not I will need to create it or remove this line.
        Route::get('/purchases/report/export', [PurchaseController::class, 'getPurchaseReport'])->name('purchases.getPurchaseReport'); // Check if this method exists
        Route::post('/purchases/report/export', [PurchaseController::class, 'exportPurchaseReport'])->name('purchases.exportPurchaseReport'); // Check if this method exists
        Route::resource('/purchases', PurchaseController::class);

        // Route Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/pending', OrderPendingController::class)->name('orders.pending');
        Route::get('/orders/complete', OrderCompleteController::class)->name('orders.complete');

        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
        Route::post('/integrations/woocommerce', [WooCommerceController::class, 'store'])->name('integrations.woocommerce.store');
        Route::post('/integrations/woocommerce/test', [WooCommerceController::class, 'test'])->name('integrations.woocommerce.test');
        Route::post('/integrations/daraz', [DarazController::class, 'store'])->name('integrations.daraz.store');
        Route::post('/integrations/daraz/test', [DarazController::class, 'test'])->name('integrations.daraz.test');
        Route::post('/integrations/leopards', [LeopardsController::class, 'store'])->name('integrations.leopards.store');
        Route::post('/integrations/leopards/test', [LeopardsController::class, 'test'])->name('integrations.leopards.test');
        Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

        Route::post('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');

        // SHOW ORDER
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/update/{order}', [OrderController::class, 'update'])->name('orders.update');

        // DUES
        Route::get('/due/orders/', [DueOrderController::class, 'index'])->name('due.index');
        Route::get('/due/order/view/{order}', [DueOrderController::class, 'show'])->name('due.show');
        Route::get('/due/order/edit/{order}', [DueOrderController::class, 'edit'])->name('due.edit');
        Route::put('/due/order/update/{order}', [DueOrderController::class, 'update'])->name('due.update');

       
        // Reports Module
        Route::prefix('reports')->name('reports.')->group(function() {
            Route::get('/', [ReportsController::class, 'index'])->name('index');
            Route::get('/sales', [ReportsController::class, 'sales'])->name('sales');
            Route::get('/purchases', [ReportsController::class, 'purchases'])->name('purchases');
            Route::get('/inventory', [ReportsController::class, 'inventory'])->name('inventory');
            Route::get('/integrations', [ReportsController::class, 'integrations'])->name('integrations');
            Route::get('/financials', [ReportsController::class, 'financials'])->name('financials');
            Route::get('/returns', [ReportsController::class, 'returns'])->name('returns');
        });

        // Integrations Module
        Route::prefix('integrations')->name('integrations.')->group(function() {
            Route::get('/', [IntegrationController::class, 'index'])->name('index');
            Route::get('/create', [IntegrationController::class, 'create'])->name('create');
            Route::get('/{id}', [IntegrationController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [IntegrationController::class, 'edit'])->name('edit');
        });

        // Template Module
        Route::prefix('template')->name('template.')->group(function() {
            Route::get('/', [TemplateController::class, 'index'])->name('index');
            Route::get('/create', [TemplateController::class, 'create'])->name('create');
            Route::get('/{id}', [TemplateController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [TemplateController::class, 'edit'])->name('edit');
        });

        // Automation Module
        Route::prefix('automation')->name('automation.')->group(function() {
            Route::get('/', [AutomationController::class, 'index'])->name('index');
            
            // Personal
            Route::prefix('personal')->name('personal.')->group(function() {
                Route::get('/details', [PersonalController::class, 'details'])->name('details');
                Route::get('/default', [PersonalController::class, 'defaultDetails'])->name('default');
                Route::get('/password', [PersonalController::class, 'passwordDetails'])->name('password');
            });

            // Company
            Route::prefix('company')->name('company.')->group(function() {
                Route::get('/details', [CompanyController::class, 'details'])->name('details');
                Route::get('/team', [CompanyController::class, 'teamMembers'])->name('team');
                Route::get('/notifications', [CompanyController::class, 'notifications'])->name('notifications');
                Route::get('/roles', [CompanyController::class, 'roles'])->name('roles');
            });

            // Configurations
            Route::prefix('configurations')->name('configurations.')->group(function() {
                Route::get('/shipping', [ConfigurationController::class, 'shipping'])->name('shipping');
                Route::get('/locations', [ConfigurationController::class, 'locations'])->name('locations');
                Route::get('/categories', [ConfigurationController::class, 'categories'])->name('categories');
                Route::get('/variations', [ConfigurationController::class, 'variations'])->name('variations');
                Route::get('/barcodes', [ConfigurationController::class, 'barcodes'])->name('barcodes');
                Route::get('/price-list', [ConfigurationController::class, 'priceList'])->name('price-list');
                Route::get('/financials', [ConfigurationController::class, 'financials'])->name('financials');
                Route::get('/taxes', [ConfigurationController::class, 'taxes'])->name('taxes');
                Route::get('/sales-process', [ConfigurationController::class, 'salesProcess'])->name('sales-process');
                Route::get('/transaction-numbers', [ConfigurationController::class, 'transactionNumbers'])->name('transaction-numbers');
                Route::get('/automations', [ConfigurationController::class, 'automations'])->name('automations');
                Route::get('/payment-methods', [ConfigurationController::class, 'paymentMethods'])->name('payment-methods');
                Route::get('/shipping-methods', [ConfigurationController::class, 'shippingMethods'])->name('shipping-methods');
                Route::get('/tags', [ConfigurationController::class, 'tags'])->name('tags');
                Route::get('/brands', [ConfigurationController::class, 'brands'])->name('brands');
                Route::get('/return-management', [ConfigurationController::class, 'returnManagement'])->name('return-management');
            });

            // Integrations
            Route::prefix('integrations')->name('integrations.')->group(function() {
                Route::get('/', [AutomationIntegrationController::class, 'index'])->name('index');
                
                // WooCommerce OAuth
                Route::get('/woocommerce/connect', [WooCommerceOAuthController::class, 'connect'])->name('woocommerce.connect');
                Route::any('/woocommerce/callback', [WooCommerceOAuthController::class, 'callback'])->name('woocommerce.callback');

                Route::get('/{slug}', [AutomationIntegrationController::class, 'show'])->name('show');
                Route::post('/{slug}', [AutomationIntegrationController::class, 'store'])->name('store');
            });

            // API Management
            Route::prefix('api-management')->name('api-management.')->group(function() {
                Route::get('/', [ApiManagementController::class, 'index'])->name('index');
                Route::post('/generate', [ApiManagementController::class, 'generate'])->name('generate');
                Route::delete('/revoke/{id}', [ApiManagementController::class, 'revoke'])->name('revoke');
            });
        });

        // TODO: Remove from OrderController
        Route::get('/orders/details/{order_id}/download', [OrderController::class, 'downloadInvoice'])->name('order.downloadInvoice');

        // Auth routes that require auth
        Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
        Route::get('/integrations/{slug}', [IntegrationController::class, 'show'])
    ->name('integrations.show');
    });
});
