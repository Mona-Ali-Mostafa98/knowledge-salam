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
            $table->longText('title')->comment('العنوان');
            $table->text('link')->comment('الرابط');
            $table->timestamp('publish_date')->nullable()->comment('تاريخ النشر');
            $table->string('publish_institution', 255)->nullable()->comment('الجهة الناشرة');
            $table->text('details')->nullable()->comment('التفاصيل');
            $table->text('tags')->nullable()->comment('الكلمات المفتاحية');
            $table->integer('article_type_id')->nullable()->comment('نوع المقال');
            $table->integer('source_location_id')->nullable()->comment('مكان المصدر');
            $table->text('attachments')->nullable()->comment('المرفقات');
            $table->integer('publish_institution_type_id')->nullable()->comment('نوع الجهة الناشرة');
            $table->integer('continent_id')->nullable()->comment('القارة');
            $table->integer('country_id')->nullable()->comment('الدولة');
            $table->string('countries')->nullable()->comment('الدول  المعنية');
            $table->integer('language_id')->nullable()->comment('اللغة');
            $table->integer('added_reason_id')->nullable()->comment('سبب الإضافة');
            $table->integer('repetition_id')->nullable()->comment('دورية التقرير');
            $table->integer('saudi_issue_direction_id')->nullable()->comment('توجه المملكة');
            $table->integer('dimension_id')->nullable()->comment('البعد');
            $table->text('dimension_text')->nullable()->comment('الوصف ');
            $table->integer('contribution_type_id')->nullable()->comment('نوع المساهمة');
            $table->longText('contribution_name')->nullable()->comment('اسم المساهم');
            $table->integer('organizations_role_id')->nullable()->comment('دور المنظمة');
            $table->integer('contribution_role_id')->nullable()->comment('دور المساهم');
            $table->integer('report_direction_id')->nullable()->comment('اتجاه التقرير');
            $table->string('cities', 255)->nullable()->comment('المدن');
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
