<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_integrations', function (Blueprint $table) {
            // Laravel 10 me hasColumn ko do arguments chahiye: table, column
            if (!Schema::hasColumn('user_integrations', 'store_nickname')) {
                $table->string('store_nickname')->nullable(); // removed after('integration_id')
            }
            if (!Schema::hasColumn('user_integrations', 'store_name')) {
                $table->string('store_name')->nullable(); // removed after()
            }
            if (!Schema::hasColumn('user_integrations', 'contact_number')) {
                $table->string('contact_number')->nullable();
            }
            if (!Schema::hasColumn('user_integrations', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('user_integrations', 'store_image')) {
                $table->string('store_image')->nullable();
            }
            if (!Schema::hasColumn('user_integrations', 'store_url')) {
                $table->string('store_url')->nullable();
            }
            if (!Schema::hasColumn('user_integrations', 'api_key')) {
                $table->text('api_key')->nullable();
            }
            if (!Schema::hasColumn('user_integrations', 'api_secret')) {
                $table->text('api_secret')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_integrations', function (Blueprint $table) {
            $columns = [
                'store_nickname',
                'store_name',
                'contact_number',
                'email',
                'store_image',
                'store_url',
                'api_key',
                'api_secret',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('user_integrations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};