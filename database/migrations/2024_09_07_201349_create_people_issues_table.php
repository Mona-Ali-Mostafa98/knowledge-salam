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
        //القضايا التي تدافع عنها الشخصية
        Schema::create('people_issues', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->string('title', 255)->nullable();
            $table->text('details')->nullable();
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->text('tags')->nullable();
            $table->integer('sector_id')->nullable();
            $table->integer('saudi_direction_id')->nullable();
            $table->text('related_points')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_issues');
    }
};
