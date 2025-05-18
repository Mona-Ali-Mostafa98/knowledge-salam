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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // الاسم الكامل
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('mobile')->nullable()->comment('رقم الجوال');
            $table->string('job_title')->nullable()->comment('الوظيفة أو الصفة');
            $table->string('national_id')->nullable()->comment('رقم الهوية الوطنية');
            $table->text('bio')->nullable()->comment('رسالة تعريفية عن المستخدم');
            $table->string('organization_id')->nullable()->comment('الجهة التابع لها');
            $table->string('sector_id')->nullable()->comment('القطاع التابع له');
            $table->text('registration_purpose')->nullable()->comment('الغرض من إنشاء الحساب');
            $table->string('identity_document')->nullable()->comment('صورة الهوية الوطنية');
            $table->string('photo')->nullable()->comment('الصورة الشخصية (رابط أو مسار الملف)');
            $table->enum('requested_role', ['content_manager', 'event_manager', 'report_viewer', 'admin'])->nullable()->comment('الدور المطلوب من المستخدم');
            $table->enum('approval_status', ['pending', 'reviewed', 'approved', 'rejected'])->default('pending')->comment('حالة الطلب');
            $table->timestamp('approved_at')->nullable()->comment('تاريخ القبول في النظام');

            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
