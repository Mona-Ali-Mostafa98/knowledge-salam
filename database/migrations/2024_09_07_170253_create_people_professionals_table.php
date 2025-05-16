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
        Schema::create('people_professionals', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->string('institution', 200);
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->text('description')->nullable();
            $table->integer('organization_type_id');
            $table->integer('organization_level_id');
            $table->integer('institution_type_id');
            $table->integer('position_id')->nullable();
            $table->integer('specialization_id')->nullable();
            $table->integer('influence_level_id')->nullable();
            $table->text('institution')->change()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_professionals');
    }
};
