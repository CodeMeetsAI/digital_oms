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
        // Check if table already exists for this tenant
        if (!Schema::hasTable('automations')) {
            Schema::create('automations', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Add name column
                $table->string('type'); // Add type column
                $table->string('status')->default('inactive'); // Default status
                $table->text('description')->nullable(); // Optional description
                $table->json('settings')->nullable(); // JSON settings
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe drop
        Schema::dropIfExists('automations');
    }
};