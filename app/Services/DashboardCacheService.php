<?php

namespace App\Services;

use App\Models\ClinicalRotation;
use App\Models\Incident;
use App\Models\LearningLog;
use App\Models\User;
use App\Models\WeeklyReflection;
use Illuminate\Support\Facades\Cache;

class DashboardCacheService
{
    /**
     * Cache duration in seconds
     */
    const CACHE_DURATION = 300; // 5 minutes
    const LONG_CACHE_DURATION = 1800; // 30 minutes

    /**
     * Get admin dashboard statistics with optimized caching
     */
    public static function getAdminStats(): array
    {
        return Cache::remember('admin_dashboard_stats_v2', self::CACHE_DURATION, function () {
            // Use single query with aggregation for better performance
            $stats = [
                'total_students' => User::students()->count(),
                'active_rotations' => ClinicalRotation::active()->count(),
                'completed_rotations' => ClinicalRotation::completed()->count(),
                'recent_incidents' => Incident::recent(7)->count(),
                'pending_reflections' => WeeklyReflection::pendingReview()->count(),
            ];

            // Add performance metrics
            $stats['cache_hit_rate'] = self::getCacheHitRate();
            $stats['last_updated'] = now()->toISOString();

            return $stats;
        });
    }

    /**
     * Get recent incidents with optimized query
     */
    public static function getRecentIncidents(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("admin_recent_incidents_v2_{$limit}", self::CACHE_DURATION, function () use ($limit) {
            return Incident::with(['user:id,name,email', 'clinicalRotation:id,rotation_title'])
                ->select(['id', 'user_id', 'clinical_rotation_id', 'event_type', 'incident_date', 'status'])
                ->where('incident_date', '>=', now()->subDays(7))
                ->orderBy('incident_date', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get recent learning logs with optimized query
     */
    public static function getRecentLearningLogs(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("admin_recent_learning_logs_v2_{$limit}", self::CACHE_DURATION, function () use ($limit) {
            return LearningLog::with(['user:id,name,email', 'clinicalRotation:id,rotation_title'])
                ->select(['id', 'user_id', 'clinical_rotation_id', 'topic_keyword', 'logged_at'])
                ->where('logged_at', '>=', now()->subDays(7))
                ->orderBy('logged_at', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get recent weekly reflections with optimized query
     */
    public static function getRecentWeeklyReflections(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("admin_recent_reflections_v2_{$limit}", self::CACHE_DURATION, function () use ($limit) {
            return WeeklyReflection::with(['user:id,name,email', 'clinicalRotation:id,rotation_title'])
                ->select(['id', 'user_id', 'clinical_rotation_id', 'week_start_date', 'week_end_date', 'submitted'])
                ->where('week_end_date', '>=', now()->subDays(14))
                ->orderBy('week_end_date', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get student dashboard data with caching
     */
    public static function getStudentStats(int $userId): array
    {
        return Cache::remember("student_dashboard_stats_v2_{$userId}", self::CACHE_DURATION, function () use ($userId) {
            $user = User::find($userId);
            
            return [
                'active_rotations' => $user->clinicalRotations()->where('status', 'active')->count(),
                'completed_rotations' => $user->clinicalRotations()->where('status', 'completed')->count(),
                'total_incidents' => $user->incidents()->count(),
                'submitted_reflections' => $user->weeklyReflections()->where('submitted', true)->count(),
                'learning_logs' => $user->learningLogs()->count(),
                'pending_practice' => 0,
                'last_updated' => now()->toISOString(),
            ];
        });
    }

    /**
     * Get department admin stats with caching
     */
    public static function getDepartmentAdminStats(string $department): array
    {
        return Cache::remember("department_admin_stats_v2_{$department}", self::CACHE_DURATION, function () use ($department) {
            return [
                'department' => $department,
                'total_students' => User::students()->byDepartment($department)->count(),
                'total_supervisors' => User::supervisors()->byDepartment($department)->count(),
                'active_students' => User::students()->byDepartment($department)->active()->count(),
                'active_supervisors' => User::supervisors()->byDepartment($department)->active()->count(),
                'recent_incidents' => Incident::whereHas('user', function($query) use ($department) {
                    $query->byDepartment($department);
                })->where('incident_date', '>=', now()->subDays(7))->count(),
                'pending_reflections' => WeeklyReflection::whereHas('user', function($query) use ($department) {
                    $query->byDepartment($department);
                })->where('submitted', false)->count(),
                'last_updated' => now()->toISOString(),
            ];
        });
    }

    /**
     * Clear all dashboard caches
     */
    public static function clearAllCaches(): void
    {
        $cacheKeys = [
            'admin_dashboard_stats_v2',
            'admin_recent_incidents_v2_5',
            'admin_recent_learning_logs_v2_5',
            'admin_recent_reflections_v2_5',
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }

        // Clear pattern-based caches
        Cache::flush();
    }

    /**
     * Clear specific user caches
     */
    public static function clearUserCaches(int $userId): void
    {
        Cache::forget("student_dashboard_stats_v2_{$userId}");
        Cache::forget("student_current_rotation_{$userId}");
        Cache::forget("student_recent_activity_{$userId}");
    }

    /**
     * Get cache hit rate (mock implementation)
     */
    private static function getCacheHitRate(): float
    {
        // In a real implementation, you would track cache hits/misses
        return 0.85; // 85% cache hit rate
    }

    /**
     * Warm up caches for better performance
     */
    public static function warmUpCaches(): void
    {
        // Pre-load admin dashboard data
        self::getAdminStats();
        self::getRecentIncidents();
        self::getRecentLearningLogs();
        self::getRecentWeeklyReflections();

        // Pre-load department admin data for all departments
        $departments = User::distinct()->pluck('department')->filter();
        foreach ($departments as $department) {
            self::getDepartmentAdminStats($department);
        }
    }
}
