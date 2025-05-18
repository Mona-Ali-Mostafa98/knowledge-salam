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
        Schema::create('people_positions', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->integer('political_position_id');
            $table->longText('person_position')->nullable();
            $table->longText('saudi_position')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_positions');
    }
};
