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
        Schema::create('people_facts', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->text('details')->nullable();
            $table->timestamp('fact_date')->nullable();
            $table->integer('achievement_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_facts');
    }
};
