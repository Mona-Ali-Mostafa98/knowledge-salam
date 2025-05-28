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
        Schema::create('people_positions_on_issues_at_events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
            ->constrained('events')
            ->onDelete('cascade')
            ->comment('الحدث');

            $table->foreignId('person_id')
            ->constrained('people')
            ->onDelete('cascade')
            ->comment('الشخصية المرتبطة بالحدث');

            $table->foreignId('issue_id')
            ->constrained('issues')
            ->onDelete('cascade')
            ->comment('القضية');

            $table->integer('person_direction_id')
            ->nullable()
            ->comment('نوع الموقف');

            $table->text('person_position')
            ->nullable()
            ->comment('موقف الشخصية من القضية');

            $table->unique(['event_id', 'person_id', 'issue_id'], 'event_person_issue_unique');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_position_on_issue_at_event');
    }
};
