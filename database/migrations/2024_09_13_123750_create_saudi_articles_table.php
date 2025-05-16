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
        Schema::create('saudi_articles', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->string('title', 255);
            $table->string('link', 255);
            $table->timestamp('publish_date')->nullable();
            $table->string('publish_institution', 255)->nullable();
            $table->text('details')->nullable();
            $table->string('articles_direction', 255)->nullable();
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
        Schema::dropIfExists('saudi_articles');
    }
};
