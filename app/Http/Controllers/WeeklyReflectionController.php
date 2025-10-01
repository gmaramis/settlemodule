<?php

namespace App\Http\Controllers;

use App\Models\WeeklyReflection;
use App\Models\ClinicalRotation;
use App\Models\User;
use App\Models\Admin;
use App\Models\Incident;
use App\Notifications\WeeklyReflectionNotification;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WeeklyReflectionController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    public function index(Request $request): View
    {
        $user = Auth::user();
        
        $query = WeeklyReflection::with(['user', 'clinicalRotation']);
        
        if ($user->is_admin) {
            // Admin can see all reflections
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

        $reflections = $query->latest('week_start_date')->paginate(10);

        // Calculate statistics
        $stats = [
            'total' => $reflections->total(),
            'submitted' => $reflections->where('submitted', true)->count(),
            'draft' => $reflections->where('submitted', false)->count(),
            'this_month' => WeeklyReflection::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count()
        ];

        return view('weekly-reflections.index', compact('reflections', 'stats'));
    }

    public function create(): View
    {
        $user = Auth::user();
        
        // Get clinical rotations from database - use existing rotations
        $rotations = ClinicalRotation::all();

        // Get current week dates
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        return view('weekly-reflections.create', compact('rotations', 'weekStart', 'weekEnd'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'clinical_rotation_id' => 'required|exists:clinical_rotations,id',
            'week_start_date' => 'required|date',
            'week_end_date' => 'required|date|after:week_start_date',
            'what_went_well_quality_safety' => 'required|string',
            'what_could_do_better' => 'required|string',
            'what_learned_safe_healthcare' => 'required|string',
            'goals_for_next_week' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['submitted'] = true;
        $validated['submitted_at'] = now();

        $reflection = WeeklyReflection::create($validated);

        // Send WhatsApp notification to admin
        try {
            $admin = Admin::getAdminForNotifications();
            $admin->notify(new WeeklyReflectionNotification($reflection));
        } catch (\Exception $e) {
            // Log error but don't fail the reflection creation
            Log::error('Failed to send WhatsApp notification for weekly reflection', [
                'reflection_id' => $reflection->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->route('weekly-reflections.index')
            ->with('success', 'Weekly reflection submitted successfully.');
    }

    public function show(WeeklyReflection $weeklyReflection): View
    {
        $this->authorize('view', $weeklyReflection);
        
        $weeklyReflection->load(['user', 'clinicalRotation']);
        
        return view('weekly-reflections.show', compact('weeklyReflection'));
    }

    public function edit(WeeklyReflection $weeklyReflection): View
    {
        $this->authorize('update', $weeklyReflection);
        
        $user = Auth::user();
        // Get clinical rotations from database - use existing rotations
        $rotations = ClinicalRotation::all();
        
        return view('weekly-reflections.edit', compact('weeklyReflection', 'rotations'));
    }

    public function update(Request $request, WeeklyReflection $weeklyReflection): RedirectResponse
    {
        $this->authorize('update', $weeklyReflection);

        $validated = $request->validate([
            'clinical_rotation_id' => 'required|exists:clinical_rotations,id',
            'week_start_date' => 'required|date',
            'week_end_date' => 'required|date|after:week_start_date',
            'what_went_well_quality_safety' => 'required|string',
            'what_could_do_better' => 'required|string',
            'what_learned_safe_healthcare' => 'required|string',
            'goals_for_next_week' => 'required|string',
        ]);

        $weeklyReflection->update($validated);

        return redirect()->route('weekly-reflections.show', $weeklyReflection)
            ->with('success', 'Weekly reflection updated successfully.');
    }

    public function destroy(WeeklyReflection $weeklyReflection): RedirectResponse
    {
        $this->authorize('delete', $weeklyReflection);

        $weeklyReflection->delete();

        return redirect()->route('weekly-reflections.index')
            ->with('success', 'Weekly reflection deleted successfully.');
    }

    public function review(WeeklyReflection $weeklyReflection): View
    {
        $this->authorize('review', $weeklyReflection);
        
        $weeklyReflection->load(['user', 'clinicalRotation']);
        
        return view('weekly-reflections.review', compact('weeklyReflection'));
    }

    public function updateReview(Request $request, WeeklyReflection $weeklyReflection): RedirectResponse
    {
        $this->authorize('review', $weeklyReflection);

        $validated = $request->validate([
            'supervisor_feedback' => 'nullable|string',
            'supervisor_comments' => 'nullable|string',
        ]);

        $validated['supervisor_reviewed_at'] = now();

        $weeklyReflection->update($validated);

        return redirect()->route('weekly-reflections.show', $weeklyReflection)
            ->with('success', 'Weekly reflection review updated successfully.');
    }

    public function submit(WeeklyReflection $weeklyReflection): RedirectResponse
    {
        $this->authorize('update', $weeklyReflection);

        if ($weeklyReflection->submitted) {
            return back()->with('error', 'This reflection has already been submitted.');
        }

        $weeklyReflection->update([
            'submitted' => true,
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Weekly reflection submitted successfully.');
    }
}
