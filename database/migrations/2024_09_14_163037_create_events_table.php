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
            $table->integer('continent_id')->nullable()->comment('القارة');
            $table->integer('country_id')->nullable()->comment('دولة الحدث');
            $table->integer('city_id')->nullable()->comment('مدينة الحدث');
            $table->decimal('latitude', 10, 7)->nullable()->comment('خط العرض');
            $table->decimal('longitude', 10, 7)->nullable()->comment('خط الطول');
            $table->string('venue')->nullable()->comment('مكان الحدث التفصيلي');

            // التوصيف
            $table->integer('sector_id')->nullable()->comment('القطاع المعني');
            $table->date('event_date')->nullable()->comment('تاريخ الحدث');
            $table->time('event_time')->nullable()->comment('توقيت اقامة الحدث');

            $table->longText('details')->nullable()->comment('تفاصيل الحدث');
            $table->enum('event_type', [
                'article', 'tweet', 'video', 'report', 'conference',
                'workshop', 'meeting', 'seminar', 'press_release',
                'interview', 'publication', 'announcement', 'webinar',
                'panel_discussion'])->nullable()->comment('نوع الحدث');
//            $table->text('issues_discussed')->nullable()->comment('القضايا التي يناقشها الحدث');
            $table->text('tags')->nullable()->comment('الكلمات المفتاحية');

            $table->text('saudi_direction')->nullable()->comment('موقف المملكة من الحدث');
            $table->integer('saudi_direction_id')->nullable()->comment('موقف المملكة');

            $table->string('url')->nullable()->comment('رابط الحدث');
            $table->enum('approval_status', ['pending', 'reviewed', 'approved', 'rejected'])->default('pending')->comment('حالة الحدث');
            $table->enum('event_status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled')->comment('حالة تنفيذ الحدث');
            $table->unsignedBigInteger('created_by')->nullable()->comment('مضاف بواسطة');
//            $table->foreignId('related_event_id')->nullable()->constrained('events')->nullOnDelete()->comment('حدث مرتبط / تابع');
            $table->unsignedBigInteger('position_type_id')->nullable()->comment('نوع الموقف');
            $table->text('note')->nullable()->comment('ملاحظات إضافية');
            $table->text('attachments')->nullable()->comment('المرفقات');

            $table->boolean('send_to_reviewer')->default(false)->comment('هل تم الارسال للمراجعة؟');
            $table->unsignedBigInteger('reviewed_by')->nullable()->comment('المستخدم الذي قام بالمراجعة');
            $table->boolean('send_to_approval')->default(false)->comment('هل تم الارسال للاعتماد؟');
            $table->unsignedBigInteger('approved_by')->nullable()->comment('المستخدم الذي قام بالتحكيم');
            $table->boolean('is_published')->default(false)->comment('تم النشر في النظام؟');
            $table->unsignedBigInteger('published_by')->nullable()->comment('المستخدم الذي قام بالنشر');
            $table->timestamp('publish_date')->nullable()->nullable()->comment('تاريخ النشر');
            $table->date('expire_date')->nullable()->comment('تاريخ انتهاء الصلاحية');

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
