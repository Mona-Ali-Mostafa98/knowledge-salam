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
        Schema::table('people_experiences', function (Blueprint $table) {
            $table->integer('start')->change();
            $table->integer('end')->change();
            $table->dropColumn('experience');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people_experiences', function (Blueprint $table) {
            //
        });
    }
};
