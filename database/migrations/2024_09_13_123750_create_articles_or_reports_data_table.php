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
        Schema::create('articles_or_reports_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade')->comment('الحدث');
            $table->integer('publish_institution_type_id')->nullable()->comment('نوع الجهة الناشرة');
            $table->string('publish_institution', 255)->nullable()->comment('الجهة الناشرة');
            $table->string('countries')->nullable()->comment('الدول  المعنية');
            $table->string('cities', 255)->nullable()->comment('المدن');
            $table->integer('language_id')->nullable()->comment('اللغة');
            $table->integer('report_direction_id')->nullable()->comment('اتجاه التقرير');
            $table->integer('added_reason_id')->nullable()->comment('سبب الإضافة');
            $table->integer('repetition_id')->nullable()->comment('دورية التقرير');
            $table->integer('saudi_issue_direction_id')->nullable()->comment('توجه المملكة');
            $table->integer('dimension_id')->nullable()->comment('البعد');
            $table->text('dimension_text')->nullable()->comment('الوصف ');
            $table->integer('contribution_type_id')->nullable()->comment('نوع المساهمة');
            $table->longText('contribution_name')->nullable()->comment('اسم المساهم');
            $table->integer('organizations_role_id')->nullable()->comment('دور المنظمة');
            $table->integer('contribution_role_id')->nullable()->comment('دور المساهم');

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
