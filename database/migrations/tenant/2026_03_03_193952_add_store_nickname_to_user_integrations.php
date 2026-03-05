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
        Schema::table('user_integrations', function (Blueprint $table) {
            // Adding 'store_nickname' column after 'platform'
            if (!Schema::hasColumn('user_integrations', 'store_nickname')) {
                $table->string('store_nickname')->nullable()->after('platform');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_integrations', function (Blueprint $table) {
            // Dropping 'store_nickname' column on rollback
            if (Schema::hasColumn('user_integrations', 'store_nickname')) {
                $table->dropColumn('store_nickname');
            }
        });
    }
};