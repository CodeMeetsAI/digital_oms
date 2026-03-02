<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations on the tenant database.
     */
    public function up(): void
    {
        Schema::table('user_integrations', function (Blueprint $table) {
            // Standard OAuth2 fields as requested
            if (!Schema::hasColumn('user_integrations', 'access_token')) {
                $table->text('access_token')->nullable()->after('secret_key');
            }
            if (!Schema::hasColumn('user_integrations', 'refresh_token')) {
                $table->text('refresh_token')->nullable()->after('access_token');
            }
            if (!Schema::hasColumn('user_integrations', 'expires_in')) {
                $table->integer('expires_in')->nullable()->after('refresh_token');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_integrations', function (Blueprint $table) {
            $table->dropColumn(['access_token', 'refresh_token', 'expires_in']);
        });
    }
};
