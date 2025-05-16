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
        Schema::create('saudi_positions', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->text('details', 255)->nullable();
            $table->timestamp('date')->nullable();
            $table->integer('direction_id')->nullable();
            $table->integer('sector_id');
            $table->text('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saudi_positions');
    }
};
