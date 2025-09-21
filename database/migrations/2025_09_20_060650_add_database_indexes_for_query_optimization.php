<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes for users table
        Schema::table('users', function (Blueprint $table) {
            // Index for role-based queries
            if (!$this->indexExists('users', 'users_role_index')) {
                $table->index('role');
            }
            // Index for department-based queries
            if (!$this->indexExists('users', 'users_department_index')) {
                $table->index('department');
            }
            // Index for active users
            if (!$this->indexExists('users', 'users_is_active_index')) {
                $table->index('is_active');
            }
            // Composite index for supervisor queries
            if (!$this->indexExists('users', 'users_role_department_index')) {
                $table->index(['role', 'department']);
            }
            // Composite index for student queries
            if (!$this->indexExists('users', 'users_role_is_active_index')) {
                $table->index(['role', 'is_active']);
            }
        });

        // Add indexes for incidents table
        Schema::table('incidents', function (Blueprint $table) {
            // Index for user-based queries
            if (!$this->indexExists('incidents', 'incidents_user_id_index')) {
                $table->index('user_id');
            }
            // Index for department-based queries
            if (!$this->indexExists('incidents', 'incidents_department_index')) {
                $table->index('department');
            }
            // Index for event type queries
            if (!$this->indexExists('incidents', 'incidents_event_type_index')) {
                $table->index('event_type');
            }
            // Index for status queries
            if (!$this->indexExists('incidents', 'incidents_status_index')) {
                $table->index('status');
            }
            // Index for incident date queries
            if (!$this->indexExists('incidents', 'incidents_incident_date_index')) {
                $table->index('incident_date');
            }
            // Composite index for recent incidents
            if (!$this->indexExists('incidents', 'incidents_incident_date_status_index')) {
                $table->index(['incident_date', 'status']);
            }
            // Composite index for user incidents
            if (!$this->indexExists('incidents', 'incidents_user_id_incident_date_index')) {
                $table->index(['user_id', 'incident_date']);
            }
        });

        // Add indexes for clinical_rotations table
        Schema::table('clinical_rotations', function (Blueprint $table) {
            // Index for user-based queries
            if (!$this->indexExists('clinical_rotations', 'clinical_rotations_user_id_index')) {
                $table->index('user_id');
            }
            // Index for status queries
            if (!$this->indexExists('clinical_rotations', 'clinical_rotations_status_index')) {
                $table->index('status');
            }
            // Composite index for user status queries
            if (!$this->indexExists('clinical_rotations', 'clinical_rotations_user_id_status_index')) {
                $table->index(['user_id', 'status']);
            }
        });

        // Add indexes for weekly_reflections table
        Schema::table('weekly_reflections', function (Blueprint $table) {
            // Index for user-based queries
            if (!$this->indexExists('weekly_reflections', 'weekly_reflections_user_id_index')) {
                $table->index('user_id');
            }
            // Index for clinical rotation queries
            if (!$this->indexExists('weekly_reflections', 'weekly_reflections_clinical_rotation_id_index')) {
                $table->index('clinical_rotation_id');
            }
            // Index for submission status
            if (!$this->indexExists('weekly_reflections', 'weekly_reflections_submitted_index')) {
                $table->index('submitted');
            }
            // Index for supervisor review status
            if (!$this->indexExists('weekly_reflections', 'weekly_reflections_supervisor_reviewed_at_index')) {
                $table->index('supervisor_reviewed_at');
            }
            // Index for week dates
            if (!$this->indexExists('weekly_reflections', 'weekly_reflections_week_start_date_index')) {
                $table->index('week_start_date');
            }
            if (!$this->indexExists('weekly_reflections', 'weekly_reflections_week_end_date_index')) {
                $table->index('week_end_date');
            }
            // Composite index for pending reviews
            if (!$this->indexExists('weekly_reflections', 'weekly_reflections_submitted_supervisor_reviewed_at_index')) {
                $table->index(['submitted', 'supervisor_reviewed_at']);
            }
            // Composite index for user reflections
            if (!$this->indexExists('weekly_reflections', 'weekly_reflections_user_id_submitted_index')) {
                $table->index(['user_id', 'submitted']);
            }
            // Composite index for overdue reflections
            if (!$this->indexExists('weekly_reflections', 'weekly_reflections_week_end_date_submitted_index')) {
                $table->index(['week_end_date', 'submitted']);
            }
        });

        // Add indexes for learning_logs table
        Schema::table('learning_logs', function (Blueprint $table) {
            // Index for user-based queries
            if (!$this->indexExists('learning_logs', 'learning_logs_user_id_index')) {
                $table->index('user_id');
            }
            // Index for clinical rotation queries
            if (!$this->indexExists('learning_logs', 'learning_logs_clinical_rotation_id_index')) {
                $table->index('clinical_rotation_id');
            }
            // Index for logged_at queries
            if (!$this->indexExists('learning_logs', 'learning_logs_logged_at_index')) {
                $table->index('logged_at');
            }
            // Index for date queries
            if (!$this->indexExists('learning_logs', 'learning_logs_date_index')) {
                $table->index('date');
            }
            // Composite index for recent logs
            if (!$this->indexExists('learning_logs', 'learning_logs_user_id_logged_at_index')) {
                $table->index(['user_id', 'logged_at']);
            }
        });

        // Add indexes for activity_logs table
        Schema::table('activity_logs', function (Blueprint $table) {
            // Index for causer queries
            if (!$this->indexExists('activity_logs', 'activity_logs_causer_id_index')) {
                $table->index('causer_id');
            }
            if (!$this->indexExists('activity_logs', 'activity_logs_causer_type_index')) {
                $table->index('causer_type');
            }
            // Index for subject queries
            if (!$this->indexExists('activity_logs', 'activity_logs_subject_id_index')) {
                $table->index('subject_id');
            }
            if (!$this->indexExists('activity_logs', 'activity_logs_subject_type_index')) {
                $table->index('subject_type');
            }
            // Index for event queries
            if (!$this->indexExists('activity_logs', 'activity_logs_event_index')) {
                $table->index('event');
            }
            // Index for log name queries
            if (!$this->indexExists('activity_logs', 'activity_logs_log_name_index')) {
                $table->index('log_name');
            }
            // Index for severity queries
            if (!$this->indexExists('activity_logs', 'activity_logs_severity_index')) {
                $table->index('severity');
            }
            // Index for status queries
            if (!$this->indexExists('activity_logs', 'activity_logs_status_index')) {
                $table->index('status');
            }
            // Index for created_at queries
            if (!$this->indexExists('activity_logs', 'activity_logs_created_at_index')) {
                $table->index('created_at');
            }
            // Composite index for recent logs
            if (!$this->indexExists('activity_logs', 'activity_logs_created_at_causer_id_index')) {
                $table->index(['created_at', 'causer_id']);
            }
            // Composite index for log filtering
            if (!$this->indexExists('activity_logs', 'activity_logs_log_name_event_index')) {
                $table->index(['log_name', 'event']);
            }
        });
    }

    /**
     * Check if an index exists on a table
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $indexes = DB::select("SHOW INDEX FROM {$table}");
        foreach ($indexes as $index) {
            if ($index->Key_name === $indexName) {
                return true;
            }
        }
        return false;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes for users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['department']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['role', 'department']);
            $table->dropIndex(['role', 'is_active']);
        });

        // Drop indexes for incidents table
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['department']);
            $table->dropIndex(['event_type']);
            $table->dropIndex(['status']);
            $table->dropIndex(['incident_date']);
            $table->dropIndex(['incident_date', 'status']);
            $table->dropIndex(['user_id', 'incident_date']);
        });

        // Drop indexes for clinical_rotations table
        Schema::table('clinical_rotations', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['user_id', 'status']);
        });

        // Drop indexes for weekly_reflections table
        Schema::table('weekly_reflections', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['clinical_rotation_id']);
            $table->dropIndex(['submitted']);
            $table->dropIndex(['supervisor_reviewed_at']);
            $table->dropIndex(['week_start_date']);
            $table->dropIndex(['week_end_date']);
            $table->dropIndex(['submitted', 'supervisor_reviewed_at']);
            $table->dropIndex(['user_id', 'submitted']);
            $table->dropIndex(['week_end_date', 'submitted']);
        });

        // Drop indexes for learning_logs table
        Schema::table('learning_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['clinical_rotation_id']);
            $table->dropIndex(['logged_at']);
            $table->dropIndex(['date']);
            $table->dropIndex(['user_id', 'logged_at']);
        });

        // Drop indexes for activity_logs table
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['causer_id']);
            $table->dropIndex(['causer_type']);
            $table->dropIndex(['subject_id']);
            $table->dropIndex(['subject_type']);
            $table->dropIndex(['event']);
            $table->dropIndex(['log_name']);
            $table->dropIndex(['severity']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['created_at', 'causer_id']);
            $table->dropIndex(['log_name', 'event']);
        });
    }
};