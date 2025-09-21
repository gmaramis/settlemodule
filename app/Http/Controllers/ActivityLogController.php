<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\LoggingService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ActivityLogController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    /**
     * Display a listing of activity logs
     */
    public function index(Request $request): View
    {
        $query = ActivityLog::with(['causer', 'subject'])
            ->latest();

        // Filter by log name
        if ($request->filled('log_name')) {
            $query->byLogName($request->log_name);
        }

        // Filter by event
        if ($request->filled('event')) {
            $query->byEvent($request->event);
        }

        // Filter by severity
        if ($request->filled('severity')) {
            $query->bySeverity($request->severity);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->forUser($request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(10);

        // Get filter options with caching for better performance
        $logNames = cache()->remember('activity_log_names', 3600, function () {
            return ActivityLog::distinct()->pluck('log_name')->filter()->sort();
        });
        $events = cache()->remember('activity_log_events', 3600, function () {
            return ActivityLog::distinct()->pluck('event')->filter()->sort();
        });
        $severities = cache()->remember('activity_log_severities', 3600, function () {
            return ActivityLog::distinct()->pluck('severity')->filter()->sort();
        });

        return view('activity-logs.index', compact(
            'logs',
            'logNames',
            'events',
            'severities'
        ));
    }

    /**
     * Display the specified activity log
     */
    public function show(ActivityLog $activityLog): View
    {
        $activityLog->load(['causer', 'subject']);
        
        return view('activity-logs.show', compact('activityLog'));
    }

    /**
     * Get activity summary for dashboard
     */
    public function summary(Request $request): JsonResponse
    {
        $days = $request->get('days', 7);
        $userId = $request->get('user_id');
        
        $user = $userId ? \App\Models\User::find($userId) : null;
        $summary = LoggingService::getActivitySummary($user, $days);

        return response()->json($summary);
    }

    /**
     * Export activity logs
     */
    public function export(Request $request)
    {
        $query = ActivityLog::with(['causer', 'subject']);

        // Apply same filters as index
        if ($request->filled('log_name')) {
            $query->byLogName($request->log_name);
        }

        if ($request->filled('event')) {
            $query->byEvent($request->event);
        }

        if ($request->filled('severity')) {
            $query->bySeverity($request->severity);
        }

        if ($request->filled('user_id')) {
            $query->forUser($request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->latest()->get();

        // Log the export action
        LoggingService::logDataOperation(
            'export',
            'Activity logs exported',
            [
                'export_format' => 'csv',
                'record_count' => $logs->count(),
                'filters_applied' => $request->only(['log_name', 'event', 'severity', 'user_id', 'date_from', 'date_to', 'search'])
            ]
        );

        $filename = 'activity_logs_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID',
                'Date',
                'Log Name',
                'Event',
                'Description',
                'User',
                'Subject Type',
                'Subject ID',
                'Severity',
                'Status',
                'IP Address'
            ]);

            // CSV data
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->log_name,
                    $log->event,
                    $log->description,
                    $log->causer?->name ?? 'System',
                    $log->subject_type,
                    $log->subject_id,
                    $log->severity,
                    $log->status,
                    $log->ip_address
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Clean up old logs (admin only)
     */
    public function cleanup(Request $request)
    {
        $this->authorize('admin', ActivityLog::class);
        
        $daysToKeep = $request->get('days', 90);
        $deletedCount = LoggingService::cleanupOldLogs($daysToKeep);

        return response()->json([
            'message' => "Successfully cleaned up {$deletedCount} old activity logs",
            'deleted_count' => $deletedCount
        ]);
    }
}