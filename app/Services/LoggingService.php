<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoggingService
{
    /**
     * Log user authentication events
     */
    public static function logAuth(string $event, ?User $user = null, array $context = []): void
    {
        $description = match($event) {
            'login' => "User logged in",
            'logout' => "User logged out",
            'login_failed' => "Login attempt failed",
            'password_reset' => "Password reset requested",
            'password_changed' => "Password changed",
            default => "Authentication event: {$event}"
        };

        ActivityLog::logActivity(
            $description,
            $event,
            'authentication',
            $user,
            $user,
            array_merge($context, [
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]),
            $event === 'login_failed' ? 'warning' : 'info'
        );

        // Also log to Laravel's default log
        Log::info("Auth: {$description}", [
            'user_id' => $user?->id,
            'event' => $event,
            'context' => $context
        ]);
    }

    /**
     * Log clinical rotation activities
     */
    public static function logClinicalRotation(string $event, $rotation, array $context = []): void
    {
        $description = match($event) {
            'created' => "Clinical rotation created: {$rotation->rotation_name}",
            'updated' => "Clinical rotation updated: {$rotation->rotation_name}",
            'started' => "Clinical rotation started: {$rotation->rotation_name}",
            'completed' => "Clinical rotation completed: {$rotation->rotation_name}",
            'cancelled' => "Clinical rotation cancelled: {$rotation->rotation_name}",
            default => "Clinical rotation {$event}: {$rotation->rotation_name}"
        };

        ActivityLog::logActivity(
            $description,
            $event,
            'clinical_rotations',
            $rotation,
            Auth::user(),
            array_merge($context, [
                'rotation_name' => $rotation->rotation_name,
                'department' => $rotation->department,
                'status' => $rotation->status,
            ])
        );
    }

    /**
     * Log incident activities
     */
    public static function logIncident(string $event, $incident, array $context = []): void
    {
        $description = match($event) {
            'created' => "Incident reported: {$incident->incident_type}",
            'updated' => "Incident updated: {$incident->incident_type}",
            'reviewed' => "Incident reviewed: {$incident->incident_type}",
            'resolved' => "Incident resolved: {$incident->incident_type}",
            'escalated' => "Incident escalated: {$incident->incident_type}",
            default => "Incident {$event}: {$incident->incident_type}"
        };

        $severity = match($incident->severity_level) {
            'critical' => 'critical',
            'high' => 'error',
            'medium' => 'warning',
            'low' => 'info',
            default => 'info'
        };

        ActivityLog::logActivity(
            $description,
            $event,
            'incidents',
            $incident,
            Auth::user(),
            array_merge($context, [
                'incident_type' => $incident->incident_type,
                'severity_level' => $incident->severity_level,
                'location' => $incident->location,
            ]),
            $severity
        );
    }

    /**
     * Log weekly reflection activities
     */
    public static function logWeeklyReflection(string $event, $reflection, array $context = []): void
    {
        $description = match($event) {
            'created' => "Weekly reflection created for week {$reflection->week_start_date->format('M d')}",
            'updated' => "Weekly reflection updated for week {$reflection->week_start_date->format('M d')}",
            'submitted' => "Weekly reflection submitted for week {$reflection->week_start_date->format('M d')}",
            'reviewed' => "Weekly reflection reviewed for week {$reflection->week_start_date->format('M d')}",
            default => "Weekly reflection {$event} for week {$reflection->week_start_date->format('M d')}"
        };

        ActivityLog::logActivity(
            $description,
            $event,
            'weekly_reflections',
            $reflection,
            Auth::user(),
            array_merge($context, [
                'week_start' => $reflection->week_start_date,
                'week_end' => $reflection->week_end_date,
                'satisfaction' => $reflection->overall_satisfaction,
            ])
        );
    }

    /**
     * Log learning log activities
     */
    public static function logLearningLog(string $event, $learningLog, array $context = []): void
    {
        $description = match($event) {
            'created' => "Learning log created: {$learningLog->title}",
            'updated' => "Learning log updated: {$learningLog->title}",
            'practiced' => "Learning log marked as practiced: {$learningLog->title}",
            'reviewed' => "Learning log reviewed: {$learningLog->title}",
            default => "Learning log {$event}: {$learningLog->title}"
        };

        ActivityLog::logActivity(
            $description,
            $event,
            'learning_logs',
            $learningLog,
            Auth::user(),
            array_merge($context, [
                'title' => $learningLog->title,
                'learning_type' => $learningLog->learning_type,
                'competency_area' => $learningLog->competency_area,
                'difficulty_level' => $learningLog->difficulty_level,
            ])
        );
    }

    /**
     * Log system events
     */
    public static function logSystem(string $event, string $description, array $context = [], string $severity = 'info'): void
    {
        ActivityLog::logActivity(
            $description,
            $event,
            'system',
            null,
            Auth::user(),
            $context,
            $severity
        );

        // Also log to Laravel's default log
        Log::log($severity, "System: {$description}", $context);
    }

    /**
     * Log security events
     */
    public static function logSecurity(string $event, string $description, array $context = []): void
    {
        ActivityLog::logActivity(
            $description,
            $event,
            'security',
            null,
            Auth::user(),
            array_merge($context, [
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]),
            'warning'
        );

        // Also log to Laravel's default log
        Log::warning("Security: {$description}", $context);
    }

    /**
     * Log data export/import events
     */
    public static function logDataOperation(string $operation, string $description, array $context = []): void
    {
        ActivityLog::logActivity(
            $description,
            $operation,
            'data_operations',
            null,
            Auth::user(),
            $context,
            'info'
        );
    }

    /**
     * Get activity summary for dashboard
     */
    public static function getActivitySummary(?User $user = null, int $days = 7): array
    {
        $query = ActivityLog::recent($days);
        
        if ($user) {
            $query->forUser($user->id);
        }

        return [
            'total_activities' => $query->count(),
            'by_event' => $query->selectRaw('event, COUNT(*) as count')
                ->groupBy('event')
                ->pluck('count', 'event')
                ->toArray(),
            'by_severity' => $query->selectRaw('severity, COUNT(*) as count')
                ->groupBy('severity')
                ->pluck('count', 'severity')
                ->toArray(),
            'by_log_name' => $query->selectRaw('log_name, COUNT(*) as count')
                ->groupBy('log_name')
                ->pluck('count', 'log_name')
                ->toArray(),
            'recent_activities' => $query->with(['causer', 'subject'])
                ->latest()
                ->limit(10)
                ->get(),
        ];
    }

    /**
     * Clean up old logs (for maintenance)
     */
    public static function cleanupOldLogs(int $daysToKeep = 90): int
    {
        $deletedCount = ActivityLog::where('created_at', '<', now()->subDays($daysToKeep))->delete();
        
        self::logSystem(
            'cleanup',
            "Cleaned up {$deletedCount} old activity logs (older than {$daysToKeep} days)",
            ['deleted_count' => $deletedCount, 'days_kept' => $daysToKeep]
        );

        return $deletedCount;
    }
}
