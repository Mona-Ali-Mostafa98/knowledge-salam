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
        Schema::create('people_experiences', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->string('institution', 255)->nullable();
            $table->string('qualification', 255)->nullable();
            $table->integer('specializations_id')->nullable();
            $table->date('start')->nullable(); // Only declare once, no change()
            $table->date('end')->nullable();   // Only declare once, no change()
            $table->text('details')->nullable();
            $table->integer('influence_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_experiences');
    }
};
