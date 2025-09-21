<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Incident;
use App\Models\LearningLog;
use App\Models\WeeklyReflection;
use App\Models\ClinicalRotation;

class CacheService
{
    /**
     * Clear all dashboard caches
     */
    public static function clearDashboardCaches(): void
    {
        Cache::forget('admin_dashboard_stats');
        Cache::forget('admin_recent_incidents');
        Cache::forget('admin_overdue_reflections');
        
        // Clear user-specific caches
        $userIds = User::pluck('id');
        foreach ($userIds as $userId) {
            Cache::forget("supervisor_dashboard_stats_{$userId}");
            Cache::forget("supervisor_pending_reviews_{$userId}");
            Cache::forget("supervisor_recent_incidents_{$userId}");
            Cache::forget("student_dashboard_stats_{$userId}");
            Cache::forget("student_current_rotation_{$userId}");
            Cache::forget("student_recent_activity_{$userId}");
            Cache::forget("department_admin_stats_{$userId}");
        }
    }

    /**
     * Clear caches for a specific user
     */
    public static function clearUserCaches(int $userId): void
    {
        Cache::forget("supervisor_dashboard_stats_{$userId}");
        Cache::forget("supervisor_pending_reviews_{$userId}");
        Cache::forget("supervisor_recent_incidents_{$userId}");
        Cache::forget("student_dashboard_stats_{$userId}");
        Cache::forget("student_current_rotation_{$userId}");
        Cache::forget("student_recent_activity_{$userId}");
        Cache::forget("department_admin_stats_{$userId}");
    }

    /**
     * Clear caches related to incidents
     */
    public static function clearIncidentCaches(): void
    {
        Cache::forget('admin_dashboard_stats');
        Cache::forget('admin_recent_incidents');
        
        // Clear supervisor caches
        $supervisorIds = User::supervisors()->pluck('id');
        foreach ($supervisorIds as $supervisorId) {
            Cache::forget("supervisor_dashboard_stats_{$supervisorId}");
            Cache::forget("supervisor_recent_incidents_{$supervisorId}");
        }
        
        // Clear student caches
        $studentIds = User::students()->pluck('id');
        foreach ($studentIds as $studentId) {
            Cache::forget("student_dashboard_stats_{$studentId}");
            Cache::forget("student_recent_activity_{$studentId}");
        }
    }

    /**
     * Clear caches related to learning logs
     */
    public static function clearLearningLogCaches(): void
    {
        Cache::forget('admin_dashboard_stats');
        
        // Clear supervisor caches
        $supervisorIds = User::supervisors()->pluck('id');
        foreach ($supervisorIds as $supervisorId) {
            Cache::forget("supervisor_dashboard_stats_{$supervisorId}");
        }
        
        // Clear student caches
        $studentIds = User::students()->pluck('id');
        foreach ($studentIds as $studentId) {
            Cache::forget("student_dashboard_stats_{$studentId}");
            Cache::forget("student_recent_activity_{$studentId}");
        }
    }

    /**
     * Clear caches related to weekly reflections
     */
    public static function clearWeeklyReflectionCaches(): void
    {
        Cache::forget('admin_dashboard_stats');
        Cache::forget('admin_overdue_reflections');
        
        // Clear supervisor caches
        $supervisorIds = User::supervisors()->pluck('id');
        foreach ($supervisorIds as $supervisorId) {
            Cache::forget("supervisor_dashboard_stats_{$supervisorId}");
            Cache::forget("supervisor_pending_reviews_{$supervisorId}");
        }
        
        // Clear student caches
        $studentIds = User::students()->pluck('id');
        foreach ($studentIds as $studentId) {
            Cache::forget("student_dashboard_stats_{$studentId}");
            Cache::forget("student_current_rotation_{$studentId}");
        }
    }

    /**
     * Clear caches related to clinical rotations
     */
    public static function clearClinicalRotationCaches(): void
    {
        Cache::forget('admin_dashboard_stats');
        
        // Clear supervisor caches
        $supervisorIds = User::supervisors()->pluck('id');
        foreach ($supervisorIds as $supervisorId) {
            Cache::forget("supervisor_dashboard_stats_{$supervisorId}");
        }
        
        // Clear student caches
        $studentIds = User::students()->pluck('id');
        foreach ($studentIds as $studentId) {
            Cache::forget("student_dashboard_stats_{$studentId}");
            Cache::forget("student_current_rotation_{$studentId}");
        }
    }

    /**
     * Warm up frequently accessed caches
     */
    public static function warmUpCaches(): void
    {
        // Warm up admin dashboard cache
        Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'total_students' => User::students()->count(),
                'total_supervisors' => User::supervisors()->count(),
                'active_rotations' => ClinicalRotation::active()->count(),
                'completed_rotations' => ClinicalRotation::completed()->count(),
                'recent_incidents' => Incident::recent(7)->count(),
                'pending_reflections' => WeeklyReflection::pendingReview()->count(),
            ];
        });

        // Warm up admin recent incidents
        Cache::remember('admin_recent_incidents', 300, function () {
            return Incident::with(['user:id,name,email', 'clinicalRotation:id,rotation_title'])
                ->select(['id', 'user_id', 'clinical_rotation_id', 'event_type', 'incident_date', 'status'])
                ->recent(7)
                ->latest('incident_date')
                ->limit(5)
                ->get();
        });

        // Warm up admin overdue reflections
        Cache::remember('admin_overdue_reflections', 300, function () {
            return WeeklyReflection::with(['user:id,name,email', 'clinicalRotation:id,rotation_title'])
                ->select(['id', 'user_id', 'clinical_rotation_id', 'week_end_date', 'submitted'])
                ->where('week_end_date', '<', now())
                ->where('submitted', false)
                ->latest('week_end_date')
                ->limit(5)
                ->get();
        });
    }
}
