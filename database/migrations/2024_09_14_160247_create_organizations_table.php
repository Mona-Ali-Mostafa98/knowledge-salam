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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->date('foundation_date')->nullable();
            $table->integer('type_id');
            $table->string('logo', 255)->nullable();
            $table->integer('continent_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('money_resource', 255)->nullable();
            $table->string('boss', 255)->nullable();
            $table->text('details')->nullable();
            $table->string('website', 255)->nullable();
            $table->text('added_reason')->nullable();
            $table->integer('status_id')->nullable();
            $table->text('references')->nullable();
            $table->string('email', 200)->nullable();
            $table->string('mobile', 200)->nullable();
            $table->string('address', 250)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
