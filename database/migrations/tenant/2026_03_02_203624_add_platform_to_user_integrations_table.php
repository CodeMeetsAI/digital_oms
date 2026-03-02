<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('user_integrations', function (Blueprint $table) {
            if (!Schema::hasColumn('user_integrations', 'platform')) {
                $table->string('platform')->after('id'); // ya id ke baad jahan suitable ho
            }
        });
    }

    public function down(): void {
        Schema::table('user_integrations', function (Blueprint $table) {
            $table->dropColumn('platform');
        });
    }
};