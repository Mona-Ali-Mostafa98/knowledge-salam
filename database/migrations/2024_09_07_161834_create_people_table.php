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

            // 1. الاسم كامل
            $table->string('first_name', 200)->nullable()->comment('الاسم الأول');
            $table->string('mid_name', 200)->nullable()->comment('الاسم الأوسط / اسم الأب');
            $table->string('last_name', 200)->nullable()->comment('الاسم الأخير / اسم العائلة');

            $table->date('bod')->nullable()->comment('تاريخ الميلاد');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();

            $table->integer('nationality_id')->nullable()->comment('الجنسية (معرف من جدول الجنسيات)');
            $table->integer('birth_country_id')->nullable()->comment('مكان الميلاد - الدولة (معرف من جدول الدول)');
            $table->integer('birth_city_id')->nullable()->comment('مكان الميلاد - المدينة (معرف من جدول المدن)');

            $table->string('accommodation', 100)->nullable()->comment('مكان الإقامة الحالي');
            $table->string('marital_status', 100)->nullable()->comment('الحالة الاجتماعية');

            $table->string('status', 100)->nullable()->comment('حالة النشاط');
            $table->string('person_status', 100)->nullable()->comment('حالة الشخصية (مثل: شخصية عامة، مجهولة...)');

            $table->text('issues')->nullable()->comment('القضايا أو المشاكل المرتبطة بالشخص');
            $table->text('references')->nullable()->comment('المصادر أو المراجع حول الشخصية');

            $table->string('cv', 255)->nullable()->comment('السيرة الذاتية (رابط أو مسار الملف)');
            $table->string('photo', 255)->nullable()->comment('الصورة الشخصية (رابط أو مسار الملف)');

            $table->integer('religion_id')->nullable()->comment('الديانة (معرف من جدول الديانات)');
            $table->integer('sect_id')->nullable()->comment('المذهب (معرف من جدول المذاهب)');//
            $table->integer('religiosity_id')->nullable()->comment('مدى التدين (معرف من جدول درجات التدين)');

            $table->text('address')->nullable()->comment('العنوان التفصيلي');

            $table->date('death_date')->nullable()->comment('تاريخ الوفاة (إن وُجد)');
            $table->string('partner_name', 244)->nullable()->comment('اسم الشريك / الزوج أو الزوجة');

            $table->boolean('global_influencer')->default(0)->comment('هل الشخصية مؤثر عالميًا؟');
            $table->boolean('saudi_interested')->default(0)->comment('هل الشخصية مهتمة بالشأن السعودي؟');
            $table->boolean('has_issues')->default(0)->comment('هل توجد قضايا مرفوعة ضد الشخصية؟');
            $table->integer('fame_reasons_id')->nullable()->comment('سبب الشهرة (معرف من جدول أسباب الشهرة)');

            $table->longText('resources')->nullable()->comment('مصادر وروابط إضافية عن الشخصية');

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
