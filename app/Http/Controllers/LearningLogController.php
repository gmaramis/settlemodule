<?php

namespace App\Http\Controllers;

use App\Models\LearningLog;
use App\Models\ClinicalRotation;
use App\Models\User;
use App\Models\Admin;
use App\Notifications\LearningLogNotification;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LearningLogController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    public function index(Request $request): View
    {
        $user = Auth::user();
        
        $query = LearningLog::with(['user', 'clinicalRotation']);
        
        if ($user->is_admin) {
            // Admin can see all learning logs
        } elseif ($user->is_supervisor) {
            $query->whereHas('user', function($query) use ($user) {
                $query->where('supervisor_id', $user->id);
            });
        } else {
            $query->where('user_id', $user->id);
        }

        // Apply filters
        if ($request->filled('student_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student_name . '%');
            });
        }

        if ($request->filled('clinical_rotation')) {
            $query->whereHas('clinicalRotation', function($q) use ($request) {
                $q->where('rotation_title', $request->clinical_rotation);
            });
        }

        $learningLogs = $query->latest('logged_at')->paginate(10);

        // Calculate statistics
        $stats = [
            'total' => $learningLogs->total(),
            'this_month' => LearningLog::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'this_week' => LearningLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'unique_students' => $learningLogs->pluck('user_id')->unique()->count()
        ];

        return view('learning-logs.index', compact('learningLogs', 'stats'));
    }

    public function create(): View
    {
        $user = Auth::user();
        $rotations = ClinicalRotation::where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->get();

        return view('learning-logs.create', compact('rotations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'clinical_rotation_id' => 'required|exists:clinical_rotations,id',
            'date' => 'required|date',
            'topic_keyword' => 'required|string|max:255',
            'what_learned' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['logged_at'] = now();

        $learningLog = LearningLog::create($validated);

        // Send WhatsApp notification to admin
        try {
            $admin = Admin::getAdminForNotifications();
            $admin->notify(new LearningLogNotification($learningLog));
        } catch (\Exception $e) {
            // Log error but don't fail the learning log creation
            Log::error('Failed to send WhatsApp notification for learning log', [
                'learning_log_id' => $learningLog->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->route('learning-logs.index')
            ->with('success', 'Learning log created successfully.');
    }

    public function show(LearningLog $learningLog): View
    {
        $this->authorize('view', $learningLog);
        
        $learningLog->load(['user', 'clinicalRotation']);
        
        return view('learning-logs.show', compact('learningLog'));
    }

    public function edit(LearningLog $learningLog): View
    {
        $this->authorize('update', $learningLog);
        
        $user = Auth::user();
        $rotations = ClinicalRotation::where('user_id', $user->id)
            ->whereIn('status', ['active', 'completed'])
            ->get();
        
        return view('learning-logs.edit', compact('learningLog', 'rotations'));
    }

    public function update(Request $request, LearningLog $learningLog): RedirectResponse
    {
        $this->authorize('update', $learningLog);

        $validated = $request->validate([
            'clinical_rotation_id' => 'required|exists:clinical_rotations,id',
            'date' => 'required|date',
            'topic_keyword' => 'required|string|max:255',
            'what_learned' => 'required|string',
        ]);

        $learningLog->update($validated);

        return redirect()->route('learning-logs.show', $learningLog)
            ->with('success', 'Learning log updated successfully.');
    }

    public function destroy(LearningLog $learningLog): RedirectResponse
    {
        $this->authorize('delete', $learningLog);

        $learningLog->delete();

        return redirect()->route('learning-logs.index')
            ->with('success', 'Learning log deleted successfully.');
    }

    public function review(LearningLog $learningLog): View
    {
        $this->authorize('review', $learningLog);
        
        $learningLog->load(['user', 'clinicalRotation']);
        
        return view('learning-logs.review', compact('learningLog'));
    }

    public function updateReview(Request $request, LearningLog $learningLog): RedirectResponse
    {
        $this->authorize('review', $learningLog);

        $validated = $request->validate([
            'supervisor_notes' => 'nullable|string',
        ]);

        $learningLog->update($validated);

        return redirect()->route('learning-logs.show', $learningLog)
            ->with('success', 'Learning log review updated successfully.');
    }

    // markPracticed method removed - requires_practice field no longer exists
}
