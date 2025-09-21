<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\ClinicalRotation;
use App\Models\Admin;
use App\Models\User;
use App\Http\Requests\StoreIncidentRequest;
use App\Notifications\IncidentReportNotification;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IncidentController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();
        
        $query = Incident::with(['user:id,name,email,department'])
            ->select(['id', 'user_id', 'event_type', 'incident_date', 'status', 'department']);
        
        if ($user->is_admin) {
            // Admin can see all incidents
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

        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $incidents = $query->latest('incident_date')->paginate(10);

        return view('incidents.index', compact('incidents'));
    }

    public function create(): View
    {
        $departments = Incident::getDepartments();
        $eventTypes = Incident::getEventTypes();
        $contributingFactors = Incident::getContributingFactors();
        $outcomes = Incident::getOutcomes();

        return view('incidents.create', compact('departments', 'eventTypes', 'contributingFactors', 'outcomes'));
    }

    public function store(StoreIncidentRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'reported';

        $incident = Incident::create($validated);

        // Send WhatsApp notification to admin
        try {
            $admin = Admin::getAdminForNotifications();
            $admin->notify(new IncidentReportNotification($incident));
        } catch (\Exception $e) {
            // Log error but don't fail the incident creation
            Log::error('Failed to send WhatsApp notification for incident', [
                'incident_id' => $incident->id,
                'error' => $e->getMessage()
            ]);
        }

        return redirect()->route('incidents.index')
            ->with('success', 'Incident reported successfully.');
    }

    public function show(Incident $incident): View
    {
        $this->authorize('view', $incident);
        
        $incident->load(['user']);
        
        return view('incidents.show', compact('incident'));
    }

    public function edit(Incident $incident): View
    {
        $this->authorize('update', $incident);
        
        $departments = Incident::getDepartments();
        $eventTypes = Incident::getEventTypes();
        $contributingFactors = Incident::getContributingFactors();
        $outcomes = Incident::getOutcomes();
        
        return view('incidents.edit', compact('incident', 'departments', 'eventTypes', 'contributingFactors', 'outcomes'));
    }

    public function update(StoreIncidentRequest $request, Incident $incident): RedirectResponse
    {
        $this->authorize('update', $incident);

        $validated = $request->validated();
        $validated['status'] = $request->input('status', $incident->status);

        $incident->update($validated);

        return redirect()->route('incidents.show', $incident)
            ->with('success', 'Incident updated successfully.');
    }

    public function destroy(Incident $incident): RedirectResponse
    {
        $this->authorize('delete', $incident);

        $incident->delete();

        return redirect()->route('incidents.index')
            ->with('success', 'Incident deleted successfully.');
    }

    public function review(Incident $incident): View
    {
        $this->authorize('review', $incident);
        
        $incident->load(['user', 'clinicalRotation']);
        
        return view('incidents.review', compact('incident'));
    }

    public function updateReview(Request $request, Incident $incident): RedirectResponse
    {
        $this->authorize('review', $incident);

        $validated = $request->validate([
            'status' => 'required|in:under_review,resolved,closed',
            'supervisor_comments' => 'nullable|string',
        ]);

        $incident->update($validated);

        return redirect()->route('incidents.show', $incident)
            ->with('success', 'Incident review updated successfully.');
    }
}
