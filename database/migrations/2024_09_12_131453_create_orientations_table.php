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
        Schema::create('orientations', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->integer('parties_id');
            $table->integer('orientation_id');
            $table->integer('commitment_id');
            $table->longText('political_positions');
            $table->longText('statements');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orientations');
    }
};
