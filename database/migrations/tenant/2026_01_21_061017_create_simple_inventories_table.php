<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('simple_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Product::class)->constrained()->cascadeOnDelete();
            $table->string('hs_code')->nullable();
            $table->string('product_type')->default('simple');
            $table->boolean('mrp_exclusive_tax')->default(false);
            $table->boolean('third_schedule')->default(false);
            $table->integer('mrp')->nullable()->comment('Maximum Retail Price');
            $table->decimal('weight', 10, 3)->nullable()->default(0);
            $table->boolean('quantity_sync')->default(false);
            $table->string('barcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simple_inventories');
    }
};
