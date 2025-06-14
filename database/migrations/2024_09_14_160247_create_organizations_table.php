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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->date('foundation_date')->nullable();
            $table->integer('type_id');
            $table->string('logo', 255)->nullable();
            $table->integer('continent_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('boss', 255)->nullable();
            $table->text('details')->nullable();
            $table->text('website')->nullable();
            $table->text('added_reason')->nullable();
            $table->integer('status_id')->nullable();
            $table->text('references')->nullable();
            $table->text('email')->nullable();
            $table->string('mobile', 200)->nullable();
            $table->integer('organization_level_id')->nullable();
            $table->integer('money_resource_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->boolean('global_influencer')->nullable();
            $table->boolean('saudi_interested')->nullable();
            $table->text('address')->nullable();
            $table->date('boss_join')->nullable();
            $table->date('boss_leave')->nullable();
            $table->longText('resources')->nullable();
            $table->enum('approval_status', ['pending', 'reviewed', 'approved', 'rejected'])->default('pending')->comment('حالة الطلب');
            $table->unsignedBigInteger('created_by')->nullable()->comment('مضاف بواسطة');

            $table->boolean('send_to_reviewer')->default(false)->comment('هل تم الارسال للمراجعة؟');
            $table->unsignedBigInteger('reviewed_by')->nullable()->comment('المستخدم الذي قام بالمراجعة');
            $table->boolean('send_to_approval')->default(false)->comment('هل تم الارسال للاعتماد؟');
            $table->unsignedBigInteger('approved_by')->nullable()->comment('المستخدم الذي قام بالتحكيم');
            $table->boolean('is_published')->default(false)->comment('تم النشر في النظام؟');
            $table->unsignedBigInteger('published_by')->nullable()->comment('المستخدم الذي قام بالنشر');
            $table->timestamp('publish_date')->nullable()->comment('تاريخ النشر في النظام');
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
        Schema::dropIfExists('organizations');
    }
};
