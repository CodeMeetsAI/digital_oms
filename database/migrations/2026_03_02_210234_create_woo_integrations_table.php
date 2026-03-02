Schema::create('woo_integrations', function (Blueprint $table) {
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
    $table->boolean('customer_category')->nullable();
    $table->boolean('take_stock_mode')->default(0);
    $table->string('take_stock_location')->nullable();
    $table->boolean('update_price')->default(0);
    $table->boolean('auto_import_products')->default(0);
    $table->boolean('sync_stock')->default(0);
    $table->boolean('update_product_on_import')->default(0);
    $table->boolean('auto_generate_sku')->default(0);

    $table->timestamps();
});