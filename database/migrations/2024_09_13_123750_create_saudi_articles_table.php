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
            $table->longText('title'); // changed from string to longText
            $table->text('link'); // changed from string to text
            $table->timestamp('publish_date')->nullable();
            $table->string('publish_institution', 255)->nullable();
            $table->text('details')->nullable();
            $table->text('tags')->nullable();
            $table->integer('article_type_id')->nullable();
            $table->integer('source_location_id')->nullable();
            $table->text('attachments')->nullable();
            $table->integer('publish_institution_type_id')->nullable();
            $table->integer('continent_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('countries')->nullable();
            $table->integer('language_id')->nullable();
            $table->integer('added_reason_id')->nullable();
            $table->integer('repetition_id')->nullable();
            $table->integer('saudi_issue_direction_id')->nullable();
            $table->integer('dimension_id')->nullable();
            $table->text('dimension_text')->nullable();
            $table->integer('contribution_type_id')->nullable();
            $table->longText('contribution_name')->nullable(); // changed from string to longText
            $table->integer('organizations_role_id')->nullable();
            $table->integer('contribution_role_id')->nullable();
            $table->integer('report_direction_id')->nullable();
            $table->string('cities', 255)->nullable();
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
