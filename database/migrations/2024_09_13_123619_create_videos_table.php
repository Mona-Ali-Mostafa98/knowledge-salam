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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->string('title', 255);
            $table->string('video_link', 255)->nullable();
            $table->timestamp('publish_date')->nullable();
            $table->text('details')->nullable();
            $table->integer('direction_id')->nullable();
            $table->text('tags')->nullable();
            $table->integer('position_type_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
