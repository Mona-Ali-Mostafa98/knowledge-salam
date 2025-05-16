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
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('added_reason');
            $table->dropColumn('address');
            $table->string('first_name', 200)->nullable();
            $table->string('mid_name', 200)->nullable();
            $table->string('last_name', 200)->nullable();
            $table->date('death_date')->nullable();
            $table->string('partner_name', 244)->nullable();
            $table->boolean('has_issues')->default(0);
            $table->boolean('global_influencer')->default(0);
            $table->boolean('saudi_interested')->default(0);
            $table->integer('fame_reasons_id')->nullable();
            $table->text('address')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            //
        });
    }
};
