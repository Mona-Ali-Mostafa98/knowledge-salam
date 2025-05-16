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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->date('bod')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('birth_country_id')->nullable();
            $table->integer('birth_city_id')->nullable();
            $table->string('accommodation', 100)->nullable();
            $table->string('marital_status', 100)->nullable();
            $table->string('cv', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->text('added_reason')->nullable();
            $table->string('status', 100)->nullable();
            $table->string('person_status', 100)->nullable();
            $table->text('issues')->nullable();
            $table->text('references')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
