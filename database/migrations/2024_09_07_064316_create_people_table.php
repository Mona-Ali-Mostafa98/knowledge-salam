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
            $table->string('first_name', 200)->nullable();
            $table->string('mid_name', 200)->nullable();
            $table->string('last_name', 200)->nullable();
            $table->date('bod')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('birth_country_id')->nullable();
            $table->integer('birth_city_id')->nullable();
            $table->string('accommodation', 100)->nullable(); // changed: removed ->change()
            $table->string('marital_status', 100)->nullable();
            $table->string('cv', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('status', 100)->nullable();
            $table->string('person_status', 100)->nullable();
            $table->text('issues')->nullable();
            $table->text('references')->nullable();
            // $table->string('email', 200)->nullable();
            // $table->string('mobile', 200)->nullable();
            $table->text('address')->nullable();
            $table->integer('religion_id')->nullable();
            $table->integer('sect_id')->nullable();
            $table->integer('religiosity_id')->nullable();
            $table->date('death_date')->nullable();
            $table->string('partner_name', 244)->nullable();
            $table->boolean('has_issues')->default(0);
            $table->boolean('global_influencer')->default(0);
            $table->boolean('saudi_interested')->default(0);
            $table->integer('fame_reasons_id')->nullable();
            $table->longText('resources')->nullable();
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
