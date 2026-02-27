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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('cnic')->nullable();
            $table->string('ntn')->nullable();
            $table->decimal('discount', 5, 2)->default(0);
            $table->string('opening_balance_type')->default('receivable'); // receivable or payable

            // Billing Address
            $table->string('billing_name')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_address_line_1')->nullable();
            $table->string('billing_address_line_2')->nullable();
            $table->string('billing_address_line_3')->nullable();
            $table->string('billing_address_line_4')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_city')->nullable();

            // Shipping Address
            $table->string('shipping_name')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_address_line_1')->nullable();
            $table->string('shipping_address_line_2')->nullable();
            $table->string('shipping_address_line_3')->nullable();
            $table->string('shipping_address_line_4')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('shipping_city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'cnic', 'ntn', 'discount', 'opening_balance_type',
                'billing_name', 'billing_phone', 'billing_address_line_1', 'billing_address_line_2',
                'billing_address_line_3', 'billing_address_line_4', 'billing_country', 'billing_city',
                'shipping_name', 'shipping_phone', 'shipping_address_line_1', 'shipping_address_line_2',
                'shipping_address_line_3', 'shipping_address_line_4', 'shipping_country', 'shipping_city',
            ]);
        });
    }
};
