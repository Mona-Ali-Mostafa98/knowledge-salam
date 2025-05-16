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
        Schema::table('saudi_articles', function (Blueprint $table) {
            $table->integer('publish_institution_type_id')->nullable();
            $table->integer('continent_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('countries')->nullable();
            $table->integer('language_id')->nullable();
            $table->integer('added_reason_id')->nullable();
            $table->integer('repetition_id')->nullable();
            $table->integer('saudi_issue_direction_id')->nullable();
            $table->integer('dimension_id')->nullable();
            $table->text('dimension_text')->nullable();
            $table->integer('contribution_type_id')->nullable();
            $table->string('contribution_name', 255)->nullable();
            $table->integer('organizations_role_id')->nullable();
            $table->integer('contribution_role_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saudi_articles', function (Blueprint $table) {
            //
        });
    }
};
