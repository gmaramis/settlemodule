<?php

namespace App\Http\Controllers;

use App\Models\ClinicalRotation;
use App\Models\Incident;
use App\Models\LearningLog;
use App\Models\User;
use App\Models\WeeklyReflection;
use App\Services\DashboardCacheService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($user->is_admin) {
            return $this->adminDashboard();
        } elseif ($user->role === 'department_admin') {
            return $this->departmentAdminDashboard();
        } else {
            // Use modern student dashboard with real data
            return $this->studentModernDashboard();
        }
    }

    private function adminDashboard(): View
    {
        // Use optimized cache service
        $stats = DashboardCacheService::getAdminStats();
        $recentIncidents = DashboardCacheService::getRecentIncidents();
        $recentLearningLogs = DashboardCacheService::getRecentLearningLogs();
        $recentReflections = DashboardCacheService::getRecentWeeklyReflections();

        return view('dashboard.admin', compact('stats', 'recentIncidents', 'recentLearningLogs', 'recentReflections'));
    }


    private function studentDashboard(): View
    {
        /** @var User $user */
        $user = Auth::user();
        
        $stats = $this->getStudentStats($user);
        $currentRotation = $this->getCurrentRotation($user);
        $upcomingDeadlines = $this->getUpcomingDeadlines($user);
        $recentActivity = $this->getRecentActivity($user);

        return view('dashboard.student', compact(
            'stats', 
            'currentRotation', 
            'upcomingDeadlines', 
            'recentActivity'
        ));
    }

    private function getStudentStats(User $user): array
    {
        return [
            'active_rotations' => $user->clinicalRotations()->where('status', 'active')->count(),
            'completed_rotations' => $user->clinicalRotations()->where('status', 'completed')->count(),
            'total_incidents' => $user->incidents()->count(),
            'submitted_reflections' => $user->weeklyReflections()->where('submitted', true)->count(),
            'learning_logs' => $user->learningLogs()->count(),
            'pending_practice' => 0, // Removed requires_practice field
        ];
    }

    private function getCurrentRotation(User $user)
    {
        return $user->clinicalRotations()
            ->where('status', 'active')
            ->with(['incidents', 'weeklyReflections', 'learningLogs'])
            ->first();
    }

    private function getUpcomingDeadlines(User $user)
    {
        $upcomingDeadlines = collect();
        
        // Add weekly reflection deadlines
        $reflectionDeadlines = WeeklyReflection::where('user_id', $user->id)
            ->where('submitted', false)
            ->where('week_end_date', '>=', now())
            ->orderBy('week_end_date')
            ->limit(3)
            ->get()
            ->map(function($reflection) {
                return [
                    'type' => 'Weekly Reflection',
                    'title' => 'Reflection for ' . $reflection->week_start_date->format('M d') . ' - ' . $reflection->week_end_date->format('M d'),
                    'due_date' => $reflection->week_end_date,
                    'url' => route('weekly-reflections.edit', $reflection),
                ];
            });

        $upcomingDeadlines = $upcomingDeadlines->merge($reflectionDeadlines);

        // Add practice deadlines (removed - requires_practice field no longer exists)
        $practiceDeadlines = collect(); // Empty collection since requires_practice field was removed
        $upcomingDeadlines = $upcomingDeadlines->merge($practiceDeadlines);

        return $upcomingDeadlines->sortBy('due_date')->take(5);
    }

    private function getRecentActivity(User $user)
    {
        $recentActivity = collect();

        // Recent incidents
        $recentIncidents = $user->incidents()
            ->where('incident_date', '>=', now()->subDays(7))
            ->latest('incident_date')
            ->limit(3)
            ->get()
            ->map(function($incident) {
                return [
                    'type' => 'Incident',
                    'title' => $incident->incident_type . ' - ' . $incident->severity_level,
                    'date' => $incident->incident_date,
                    'url' => route('incidents.show', $incident),
                ];
            });

        $recentActivity = $recentActivity->merge($recentIncidents);

        // Recent learning logs
        $recentLogs = $user->learningLogs()
            ->where('logged_at', '>=', now()->subDays(7))
            ->latest('logged_at')
            ->limit(3)
            ->get()
            ->map(function($log) {
                return [
                    'type' => 'Learning Log',
                    'title' => $log->title,
                    'date' => $log->logged_at,
                    'url' => route('learning-logs.show', $log),
                ];
            });

        $recentActivity = $recentActivity->merge($recentLogs);

        return $recentActivity->sortByDesc('date')->take(5);
    }

    private function studentModernDashboard(): View
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Use optimized cache service
        $stats = DashboardCacheService::getStudentStats($user->id);

        // Cache current rotation for 10 minutes
        $currentRotation = cache()->remember("student_current_rotation_{$user->id}", 600, function () use ($user) {
            return $user->clinicalRotations()
                ->select(['id', 'rotation_title', 'status'])
                ->where('status', 'active')
                ->with([
                    'incidents:id,clinical_rotation_id,event_type,incident_date',
                    'weeklyReflections:id,clinical_rotation_id,week_start_date,week_end_date,submitted',
                    'learningLogs:id,clinical_rotation_id,logged_at'
                ])
                ->first();
        });

        // Cache recent activity for 5 minutes
        $recentActivity = cache()->remember("student_recent_activity_{$user->id}", 300, function () use ($user) {
            $recentActivity = collect();

            // Recent incidents
            $recentIncidents = $user->incidents()
                ->select(['id', 'event_type', 'incident_date'])
                ->where('incident_date', '>=', now()->subDays(7))
                ->latest('incident_date')
                ->limit(3)
                ->get()
                ->map(function($incident) {
                    return [
                        'type' => 'Incident',
                        'title' => $incident->event_type ?? 'Unknown Type',
                        'date' => $incident->incident_date,
                        'url' => route('incidents.show', $incident),
                    ];
                });

            $recentActivity = $recentActivity->merge($recentIncidents);

            // Recent learning logs
            $recentLogs = $user->learningLogs()
                ->select(['id', 'topic_keyword', 'logged_at'])
                ->where('logged_at', '>=', now()->subDays(7))
                ->latest('logged_at')
                ->limit(3)
                ->get()
                ->map(function($log) {
                    return [
                        'type' => 'Learning Log',
                        'title' => $log->topic_keyword,
                        'date' => $log->logged_at,
                        'url' => route('learning-logs.show', $log),
                    ];
                });

            $recentActivity = $recentActivity->merge($recentLogs);

            return $recentActivity->sortByDesc('date')->take(5);
        });

        return view('dashboard.student-modern', compact(
            'stats', 
            'currentRotation', 
            'recentActivity'
        ));
    }

    private function departmentAdminDashboard(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $department = $user->department;

        // Department-specific statistics
        $stats = [
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
        ];

        // Recent students
        $recentStudents = User::students()
            ->byDepartment($department)
            ->latest()
            ->limit(5)
            ->get();

        // Recent supervisors
        $recentSupervisors = User::supervisors()
            ->byDepartment($department)
            ->latest()
            ->limit(5)
            ->get();

        // Recent incidents from department students
        $recentIncidents = Incident::with(['user', 'clinicalRotation'])
            ->whereHas('user', function($query) use ($department) {
                $query->byDepartment($department);
            })
            ->where('incident_date', '>=', now()->subDays(7))
            ->latest('incident_date')
            ->limit(5)
            ->get();

        // Pending weekly reflections from department students
        $pendingReflections = WeeklyReflection::with(['user', 'clinicalRotation'])
            ->whereHas('user', function($query) use ($department) {
                $query->byDepartment($department);
            })
            ->where('submitted', false)
            ->where('week_end_date', '<', now())
            ->latest('week_end_date')
            ->limit(5)
            ->get();

        return view('dashboard.department-admin', compact(
            'stats',
            'recentStudents',
            'recentSupervisors', 
            'recentIncidents',
            'pendingReflections'
        ));
    }
}