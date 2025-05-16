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
            $table->string('position', 200);
            $table->string('influence', 200)->nullable();
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->text('description')->nullable();
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
