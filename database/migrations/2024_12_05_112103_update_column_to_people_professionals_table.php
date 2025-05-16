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
        Schema::table('people_professionals', function (Blueprint $table) {
            $table->dropColumn('position');
            $table->dropColumn('influence');
            $table->integer('organization_type_id');
            $table->integer('organization_level_id');
            $table->integer('institution_type_id');
            $table->integer('position_id')->nullable();
            $table->integer('specialization_id')->nullable();
            $table->integer('influence_level_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people_professionals', function (Blueprint $table) {
            //
        });
    }
};
