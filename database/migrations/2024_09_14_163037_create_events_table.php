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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->comment('عنوان الحدث');
            // address
            $table->integer('country_id')->nullable()->comment('دولة الحدث');
            $table->integer('city_id')->nullable()->comment('مدينة الحدث');
            $table->string('venue')->nullable()->comment('مكان الحدث التفصيلي');

            // التوصيف
            $table->integer('sector_id')->nullable()->comment('القطاع المعني');
            $table->date('event_date')->nullable()->comment('تاريخ الحدث');
            $table->longText('details')->nullable()->comment('تفاصيل الحدث');
            $table->enum('event_type', [
                'article', 'tweet', 'video', 'report', 'conference',
                'workshop', 'meeting', 'seminar', 'press_release',
                'interview', 'publication', 'announcement', 'webinar',
                'panel_discussion'])->nullable()->comment('نوع الحدث');
//            $table->text('issues_discussed')->nullable()->comment('القضايا التي يناقشها الحدث');
            $table->text('tags')->nullable()->comment('الكلمات المفتاحية');

            $table->foreignId('organization_id')->nullable()->constrained('organizations')->nullOnDelete()->comment('المنظمة المرتبطة بالحدث');
            $table->integer('organization_role_id')->nullable()->comment('دور المنظمة');
            $table->text('organization_position')->nullable()->comment('موقف المنظمة من الحدث');
            $table->text('saudi_direction')->nullable()->comment('موقف المملكة من الحدث');
            $table->integer('saudi_direction_id')->nullable()->comment('موقف المملكة');

            $table->string('url')->nullable()->comment('رابط الحدث');
            $table->enum('approval_status', ['pending', 'reviewed', 'approved', 'rejected'])->default('pending')->comment('حالة الحدث');
            $table->enum('event_status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled')->comment('حالة تنفيذ الحدث');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->comment('المستخدم الذي أضاف الحدث');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->comment('آخر من عدّل الحدث');
//            $table->foreignId('related_event_id')->nullable()->constrained('events')->nullOnDelete()->comment('حدث مرتبط / تابع');
            $table->unsignedBigInteger('position_type_id')->nullable()->comment('نوع الموقف');
            $table->string('person_id')->nullable()->comment('الشخصيه او الشخصيات المرتبطه بالحدث'); // multi select
            $table->timestamp('publish_date')->nullable()->nullable()->comment('تاريخ النشر');
            $table->text('note')->nullable()->comment('ملاحظات إضافية');

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
