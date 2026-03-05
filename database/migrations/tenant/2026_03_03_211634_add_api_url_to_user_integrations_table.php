<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('user_integrations', function (Blueprint $table) {
        $table->string('api_url')->nullable()->after('store_name');
    });
}

public function down()
{
    Schema::table('user_integrations', function (Blueprint $table) {
        $table->dropColumn('api_url');
    });
}
};
