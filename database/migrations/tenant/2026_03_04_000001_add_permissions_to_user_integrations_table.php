<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_integrations', function (Blueprint $table) {
            if (!Schema::hasColumn('user_integrations', 'fetch_products')) {
                $table->boolean('fetch_products')->default(false);
                $table->boolean('auto_import_orders')->default(false);
                $table->boolean('sync_stock')->default(false);
                $table->boolean('update_product')->default(false);
                $table->boolean('push_fulfillment')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_integrations', function (Blueprint $table) {
            $table->dropColumn([
                'fetch_products', 
                'auto_import_orders', 
                'sync_stock', 
                'update_product', 
                'push_fulfillment'
            ]);
        });
    }
};
