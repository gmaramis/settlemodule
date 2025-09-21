<?php

namespace App\Http\Controllers;

use App\Models\ClinicalRotation;
use App\Models\User;
use App\Services\LoggingService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ClinicalRotationController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    public function index(): View
    {
        $user = Auth::user();
        
        if ($user->is_admin) {
            $rotations = ClinicalRotation::with('user')->latest()->paginate(10);
        } elseif ($user->is_supervisor) {
            $rotations = ClinicalRotation::with('user')->latest()->paginate(10);
        } else {
            $rotations = $user->clinicalRotations()->latest()->paginate(10);
        }

        return view('clinical-rotations.index', compact('rotations'));
    }

    public function create(): View
    {
        return view('clinical-rotations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rotation_title' => 'required|string|max:255',
        ]);

        // Add user_id from authenticated user
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'scheduled';

        $rotation = ClinicalRotation::create($validated);

        // Log the creation
        LoggingService::logClinicalRotation('created', $rotation, [
            'created_by' => Auth::user()->name,
            'student' => $rotation->user->name
        ]);

        return redirect()->route('clinical-rotations.index')
            ->with('success', 'Clinical rotation created successfully.');
    }

    public function show(ClinicalRotation $clinicalRotation): View
    {
        $this->authorize('view', $clinicalRotation);
        
        $clinicalRotation->load(['user', 'incidents', 'weeklyReflections', 'learningLogs']);
        
        return view('clinical-rotations.show', compact('clinicalRotation'));
    }

    public function edit(ClinicalRotation $clinicalRotation): View
    {
        $this->authorize('update', $clinicalRotation);
        
        $students = User::students()->active()->get();
        
        return view('clinical-rotations.edit', compact('clinicalRotation', 'students'));
    }

    public function update(Request $request, ClinicalRotation $clinicalRotation): RedirectResponse
    {
        $this->authorize('update', $clinicalRotation);

        $validated = $request->validate([
            'rotation_title' => 'required|string|max:255',
            'status' => 'required|in:scheduled,active,completed,cancelled',
            'evaluation_score' => 'nullable|numeric|min:0|max:10',
            'evaluation_comments' => 'nullable|string',
        ]);

        $clinicalRotation->update($validated);

        return redirect()->route('clinical-rotations.show', $clinicalRotation)
            ->with('success', 'Clinical rotation updated successfully.');
    }

    public function destroy(ClinicalRotation $clinicalRotation): RedirectResponse
    {
        $this->authorize('delete', $clinicalRotation);

        $clinicalRotation->delete();

        return redirect()->route('clinical-rotations.index')
            ->with('success', 'Clinical rotation deleted successfully.');
    }

    public function start(ClinicalRotation $clinicalRotation): RedirectResponse
    {
        $this->authorize('update', $clinicalRotation);

        if ($clinicalRotation->status !== 'scheduled') {
            return back()->with('error', 'Only scheduled rotations can be started.');
        }

        $clinicalRotation->update(['status' => 'active']);

        return back()->with('success', 'Clinical rotation started successfully.');
    }

    public function complete(ClinicalRotation $clinicalRotation): RedirectResponse
    {
        $this->authorize('update', $clinicalRotation);

        if ($clinicalRotation->status !== 'active') {
            return back()->with('error', 'Only active rotations can be completed.');
        }

        $clinicalRotation->update(['status' => 'completed']);

        return back()->with('success', 'Clinical rotation completed successfully.');
    }
}
