<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('user_integrations', function (Blueprint $table) {
            if (!Schema::hasColumn('user_integrations', 'platform')) {
                $table->string('platform')->after('id');
            }
            if (!Schema::hasColumn('user_integrations', 'access_token')) {
                $table->text('access_token')->nullable()->after('api_secret');
            }
            if (!Schema::hasColumn('user_integrations', 'refresh_token')) {
                $table->text('refresh_token')->nullable()->after('access_token');
            }
            if (!Schema::hasColumn('user_integrations', 'expires_in')) {
                $table->integer('expires_in')->nullable()->after('refresh_token');
            }
            if (!Schema::hasColumn('user_integrations', 'last_sync_at')) {
                $table->timestamp('last_sync_at')->nullable()->after('expires_in');
            }
        });
    }

    public function down(): void {
        Schema::table('user_integrations', function (Blueprint $table) {
            $table->dropColumn(['platform','access_token','refresh_token','expires_in','last_sync_at']);
        });
    }
};