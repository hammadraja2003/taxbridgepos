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
        Schema::table('business_configurations', function (Blueprint $table) {
            $table->string('sandbox_api_key')->nullable()->after('fbr_env');
            $table->string('production_api_key')->nullable()->after('sandbox_api_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_configurations', function (Blueprint $table) {
            $table->dropColumn(['sandbox_api_key', 'production_api_key']);
        });
    }
};
