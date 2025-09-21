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
        Schema::table('incidents', function (Blueprint $table) {
            // Drop indexes that reference columns we're about to drop
            $table->dropIndex(['severity_level', 'status']);
            
            // Check if columns exist before dropping them
            $columnsToDrop = [];
            if (Schema::hasColumn('incidents', 'incident_type')) {
                $columnsToDrop[] = 'incident_type';
            }
            if (Schema::hasColumn('incidents', 'severity_level')) {
                $columnsToDrop[] = 'severity_level';
            }
            if (Schema::hasColumn('incidents', 'location')) {
                $columnsToDrop[] = 'location';
            }
            if (Schema::hasColumn('incidents', 'immediate_response')) {
                $columnsToDrop[] = 'immediate_response';
            }
            if (Schema::hasColumn('incidents', 'follow_up_actions')) {
                $columnsToDrop[] = 'follow_up_actions';
            }
            if (Schema::hasColumn('incidents', 'lessons_learned')) {
                $columnsToDrop[] = 'lessons_learned';
            }
            if (Schema::hasColumn('incidents', 'reported_by')) {
                $columnsToDrop[] = 'reported_by';
            }
            if (Schema::hasColumn('incidents', 'supervisor_notified')) {
                $columnsToDrop[] = 'supervisor_notified';
            }
            if (Schema::hasColumn('incidents', 'requires_follow_up')) {
                $columnsToDrop[] = 'requires_follow_up';
            }
            if (Schema::hasColumn('incidents', 'follow_up_date')) {
                $columnsToDrop[] = 'follow_up_date';
            }
            if (Schema::hasColumn('incidents', 'supervisor_comments')) {
                $columnsToDrop[] = 'supervisor_comments';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
            
            // Add new structured fields
            $table->string('department')->after('clinical_rotation_id');
            $table->string('event_type')->after('department');
            $table->text('event_type_explanation')->nullable()->after('event_type');
            $table->text('what_happened')->after('event_type_explanation');
            $table->text('why_did_it_happen')->after('what_happened');
            $table->json('contributing_factors')->nullable()->after('why_did_it_happen');
            $table->string('outcome')->after('contributing_factors');
            $table->text('prevention_suggestions')->nullable()->after('outcome');
            
            // Add new indexes
            $table->index(['event_type', 'status']);
            $table->index(['department', 'incident_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            // Remove new fields
            $table->dropColumn([
                'department',
                'event_type',
                'event_type_explanation',
                'what_happened',
                'why_did_it_happen',
                'contributing_factors',
                'outcome',
                'prevention_suggestions'
            ]);
            
            // Restore old fields
            $table->string('incident_type');
            $table->string('severity_level');
            $table->string('location');
            $table->text('immediate_response')->nullable();
            $table->text('follow_up_actions')->nullable();
            $table->text('lessons_learned')->nullable();
            $table->string('reported_by')->nullable();
            $table->string('supervisor_notified')->nullable();
            $table->boolean('requires_follow_up')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->text('supervisor_comments')->nullable();
        });
    }
};
