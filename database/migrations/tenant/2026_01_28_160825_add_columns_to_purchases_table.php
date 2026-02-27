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
            $table->string('po_reference')->nullable()->after('purchase_no');
            $table->integer('payment_status')->default(1)->after('status'); // 1 = Unpaid
            $table->integer('shipment_status')->default(1)->after('payment_status'); // 1 = Unfulfilled
            $table->decimal('tax_amount', 10, 2)->default(0)->after('total_amount');
            $table->decimal('due_amount', 10, 2)->default(0)->after('tax_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['po_reference', 'payment_status', 'shipment_status', 'tax_amount', 'due_amount']);
        });
    }
};
