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
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('money_resource');
            $table->integer('organization_level_id')->nullable();
            $table->integer('money_resource_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->boolean('global_influencer')->nullable();
            $table->boolean('saudi_interested')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            //
        });
    }
};
