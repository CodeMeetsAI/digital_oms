<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier_categories', function (Blueprint $table) {
            $table->string('tenant_id')->nullable()->index()->after('id');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('tenant_id')->nullable()->index()->after('id');
        });

        $tenantId = function_exists('tenant') && tenant() ? tenant('id') : null;

        if ($tenantId) {
            DB::table('supplier_categories')->whereNull('tenant_id')->update(['tenant_id' => $tenantId]);
            DB::table('suppliers')->whereNull('tenant_id')->update(['tenant_id' => $tenantId]);
        }
    }

    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropColumn('tenant_id');
        });

        Schema::table('supplier_categories', function (Blueprint $table) {
            $table->dropIndex(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }
};
