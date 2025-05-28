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
        Schema::create('organization_positions_on_issues_at_events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained('events', 'id', 'fk_opiea_event')
                ->onDelete('cascade')
                ->comment('Event');

            $table->foreignId('organization_id')
                ->constrained('organizations', 'id', 'fk_opiea_org')
                ->onDelete('cascade')
                ->comment('Organization related to event');

            $table->integer('organization_role_id')
                ->nullable()
                ->comment('Organization role');

            $table->foreignId('issue_id')
                ->constrained('issues', 'id', 'fk_opiea_issue')
                ->onDelete('cascade')
                ->comment('Issue');
            $table->integer('organization_direction_id')
                ->nullable()
                ->comment('نوع الموقف');

            $table->text('organization_position')
                ->nullable()
                ->comment('Organization position on issue');

            $table->unique(['event_id', 'organization_id', 'issue_id'], 'event_organization_issue_unique');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_positions_on_issues_at_events');
    }
};
