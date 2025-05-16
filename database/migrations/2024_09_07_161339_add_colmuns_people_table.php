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
        Schema::table('people', function (Blueprint $table) {
            $table->integer('religion_id')->nullable();
            $table->integer('sect_id')->nullable();
            $table->integer('religiosity_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('religion_id')();
            $table->dropColumn('sect_id');
            $table->dropColumn('religiosity_id');
        });
    }
};
