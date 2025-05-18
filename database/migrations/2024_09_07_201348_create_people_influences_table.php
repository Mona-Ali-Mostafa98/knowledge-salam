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
        // التأثير الإعلامي
        Schema::create('people_influences', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->integer('social_id');
            $table->integer('flowers')->default(0);
            $table->integer('viewers')->default(0);
            $table->integer('likes')->default(0);
            $table->integer('comments')->default(0);
            $table->timestamp('influence_date')->nullable();
            $table->integer('event_id')->nullable();
            $table->integer('influence_type_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_influences');
    }
};
