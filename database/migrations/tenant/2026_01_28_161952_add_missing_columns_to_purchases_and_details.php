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
        Schema::table('purchases', function (Blueprint $table) {
            $table->date('due_date')->nullable()->after('date');
            $table->text('notes')->nullable()->after('status');
            $table->decimal('discount_percentage', 5, 2)->default(0)->after('tax_amount');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('discount_percentage');
        });

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->decimal('product_discount_percentage', 5, 2)->default(0)->after('unitcost');
            $table->decimal('product_discount_amount', 10, 2)->default(0)->after('product_discount_percentage');
            $table->decimal('product_tax_amount', 10, 2)->default(0)->after('product_discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['due_date', 'notes', 'discount_percentage', 'discount_amount']);
        });

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->dropColumn(['product_discount_percentage', 'product_discount_amount', 'product_tax_amount']);
        });
    }
};
