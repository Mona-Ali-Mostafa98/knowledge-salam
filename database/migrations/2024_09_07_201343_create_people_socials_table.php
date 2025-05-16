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
        Schema::create('people_socials', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->integer('type_id');
            $table->string('link', 200);
            $table->integer('status_id');
            $table->integer('flower_count')->default(0);
            $table->integer('influence_level_id')->nullable();
            $table->text('link')->change()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_socials');
    }
};
