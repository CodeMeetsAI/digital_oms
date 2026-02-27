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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('cnic')->nullable();
            $table->string('ntn')->nullable();
            $table->string('website')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->string('bank_branch')->nullable();
            $table->string('iban')->nullable();
            $table->string('swift')->nullable();
            $table->string('bank_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['cnic', 'ntn', 'website', 'category_id', 'opening_balance', 'bank_branch', 'iban', 'swift', 'bank_address']);
        });
    }
};
