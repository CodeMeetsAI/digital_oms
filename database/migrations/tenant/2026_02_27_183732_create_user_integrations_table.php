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
        Schema::create('user_integrations', function (Blueprint $table) {
            $table->id();
            // user_id references users table (standard Laravel users migration runs early)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            // integration_id references integrations table (created in 2026_02_27_183719)
            $table->foreignId('integration_id')->constrained('integrations')->onDelete('cascade');
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->string('store_url')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_integrations');
    }
};
