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
        // Check if table exists from previous automation steps, if not, create it
        if (!Schema::hasTable('user_integrations')) {
            Schema::create('user_integrations', function (Blueprint $table) {
                $table->id();
                $table->string('platform'); // woocommerce, shopify, daraz
                $table->string('store_url');
                $table->text('api_key');
                $table->text('secret_key')->nullable();
                $table->string('status')->default('pending');
                $table->timestamp('last_sync_at')->nullable();
                $table->timestamps();
            });
        } else {
            // Update existing table to match new requirements if necessary
            Schema::table('user_integrations', function (Blueprint $table) {
                if (!Schema::hasColumn('user_integrations', 'platform')) {
                    $table->string('platform')->after('id');
                }
                if (!Schema::hasColumn('user_integrations', 'secret_key')) {
                    $table->text('secret_key')->nullable()->after('api_key');
                }
                if (!Schema::hasColumn('user_integrations', 'last_sync_at')) {
                    $table->timestamp('last_sync_at')->nullable()->after('status');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_integrations');
    }
};
