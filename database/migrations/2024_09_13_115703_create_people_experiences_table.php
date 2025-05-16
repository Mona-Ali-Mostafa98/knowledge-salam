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
            $table->string('institution', 255);
            $table->string('qualification', 255)->nullable();
            $table->integer('specializations_id')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->text('details')->nullable();
            $table->integer('influence_id')->nullable();
            $table->integer('start')->change();
            $table->integer('end')->change();
            $table->date('start')->change()->nullable();
            $table->date('end')->change()->nullable();
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
        Schema::dropIfExists('people_experiences');
    }
};
