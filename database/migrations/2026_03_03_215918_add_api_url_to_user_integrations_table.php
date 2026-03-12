<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_integrations', function (Blueprint $table) {
    $table->id();
    $table->string('store_name');
    // other columns
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::table('user_integrations', function (Blueprint $table) {
            $table->dropColumn('api_url');
        });
    }
};