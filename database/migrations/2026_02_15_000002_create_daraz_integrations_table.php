<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daraz_integrations', function (Blueprint $table) {
            $table->id();
            $table->string('store_nickname')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('store_image')->nullable();
            $table->string('api_url');
            $table->string('api_secret');
            $table->string('api_key');
            $table->boolean('push_fulfillment')->default(false);
            $table->boolean('pull_delivery_status')->default(false);
            $table->boolean('sync_stock')->default(false);
            $table->boolean('auto_import_orders')->default(false);
            $table->string('customer_category')->nullable();
            $table->enum('take_stock_mode', ['all', 'specific'])->default('all');
            $table->string('take_stock_location')->nullable();
            $table->boolean('update_price')->default(false);
            $table->boolean('auto_import_products')->default(false);
            $table->boolean('update_product_on_import')->default(false);
            $table->boolean('auto_generate_sku')->default(false);
            $table->string('fulfill_fbd_location')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daraz_integrations');
    }
};
