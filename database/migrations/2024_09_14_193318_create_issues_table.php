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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('issue_name')->comment('اسم القضية');
            $table->unsignedBigInteger('issue_type')->comment('نوع القضية');
            $table->unsignedBigInteger('issue_field')->comment('مجال القضية');
            $table->text('issue_description')->nullable()->comment('شرح القضية');
            $table->text('saudi_direction')->nullable()->comment('موقف المملكة من القضية');
            $table->text('official_response')->nullable()->comment('الرد الرسمي حول القضية');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
