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
        Schema::create('organization_people', function (Blueprint $table) {
            $table->id();
            $table->integer('person_id');
            $table->integer('organization_id');
            $table->date('register_date');
            $table->date('leave_date')->nullable();
            $table->integer('role_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_people');
    }
};
