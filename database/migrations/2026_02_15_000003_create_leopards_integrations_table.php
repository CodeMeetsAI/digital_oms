<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leopards_integrations', function (Blueprint $table) {
            $table->id();
            $table->string('account_nickname');
            $table->string('courier_company')->default('Leopards');
            $table->string('email')->nullable();
            $table->string('support_no')->nullable();
            $table->string('landline_no')->nullable();
            $table->string('address')->nullable();
            $table->string('account_no')->nullable();
            $table->string('shipper_id')->nullable();
            $table->string('api_key');
            $table->string('api_password');
            $table->string('default_weight')->nullable();
            $table->text('default_note')->nullable();
            $table->boolean('auto_sync_fulfillment')->default(false);
            $table->boolean('set_product_details_remarks')->default(false);
            $table->boolean('set_product_details_label')->default(false);
            $table->boolean('allow_open_shipment')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leopards_integrations');
    }
};
