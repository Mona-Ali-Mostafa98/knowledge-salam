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
        Schema::table('people_orientations', function (Blueprint $table) {
            $table->boolean('has_party')->default(0);
            $table->longText('meeting_points')->nullable();
            $table->longText('saudi_issue_position')->nullable();
            $table->dropColumn('statements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people_orientations', function (Blueprint $table) {
            //
        });
    }
};
