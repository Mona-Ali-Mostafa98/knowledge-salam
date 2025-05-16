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
        Schema::rename('orientations', 'people_orientations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orientations', function (Blueprint $table) {
            Schema::rename('people_orientations', 'orientations');
        });
    }
};
