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
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable(); // Account code if needed
            $table->string('type'); // Asset, Liability, Equity, Revenue, Expense
            $table->text('description')->nullable();
            $table->boolean('status')->default(true); // Active = true
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->string('payment_mode')->nullable();
            $table->string('assigned_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chart_of_accounts');
    }
};
