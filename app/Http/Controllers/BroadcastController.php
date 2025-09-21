<?php

namespace App\Http\Controllers;

use App\Models\BroadcastMessage;
use App\Models\User;
use App\Services\BroadcastService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BroadcastController extends Controller
{
    protected $broadcastService;

    public function __construct(BroadcastService $broadcastService)
    {
        $this->middleware('auth');
        $this->middleware('can:admin')->except(['show', 'getStudents']);
        $this->broadcastService = $broadcastService;
    }

    /**
     * Display a listing of broadcast messages
     */
    public function index(): View
    {
        $broadcasts = BroadcastMessage::with('creator')
            ->latest()
            ->paginate(15);

        $stats = $this->broadcastService->getBroadcastStats();

        return view('admin.broadcasts.index', compact('broadcasts', 'stats'));
    }

    /**
     * Show the form for creating a new broadcast message
     */
    public function create(): View
    {
        return view('admin.broadcasts.create');
    }

    /**
     * Store a newly created broadcast message
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'target_type' => 'required|string|in:all,specific',
            'selected_students' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare target criteria based on target type
        $targetCriteria = ['target_type' => $request->target_type];
        
        if ($request->target_type === 'specific') {
            $selectedStudents = json_decode($request->selected_students, true) ?? [];
            $targetCriteria['selected_students'] = $selectedStudents;
        }

        $broadcastMessage = BroadcastMessage::create([
            'title' => $request->title,
            'message' => $request->message,
            'created_by' => Auth::id(),
            'target_criteria' => $targetCriteria,
        ]);

        return redirect()->route('broadcasts.show', $broadcastMessage)
            ->with('success', 'Pesan broadcast berhasil dibuat.');
    }

    /**
     * Display the specified broadcast message
     */
    public function show(BroadcastMessage $broadcast): View
    {
        $broadcast->load('creator');

        return view('admin.broadcasts.show', compact('broadcast'));
    }

    /**
     * Show the form for editing the specified broadcast message
     */
    public function edit(BroadcastMessage $broadcast)
    {
        if (!$broadcast->canBeEdited()) {
            return redirect()->route('broadcasts.show', $broadcast)
                ->with('error', 'Pesan broadcast tidak dapat diedit karena sudah dikirim.');
        }

        return view('admin.broadcasts.edit', compact('broadcast'));
    }

    /**
     * Update the specified broadcast message
     */
    public function update(Request $request, BroadcastMessage $broadcast): RedirectResponse
    {
        if (!$broadcast->canBeEdited()) {
            return redirect()->route('broadcasts.show', $broadcast)
                ->with('error', 'Pesan broadcast tidak dapat diedit karena sudah dikirim.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'target_criteria' => 'nullable|array',
            'target_criteria.role' => 'nullable|string|in:all,student',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $broadcast->update([
            'title' => $request->title,
            'message' => $request->message,
            'target_criteria' => $request->target_criteria,
            'scheduled_at' => $request->scheduled_at,
        ]);

        // Jika ada jadwal, gunakan service untuk scheduling
        if ($request->scheduled_at) {
            $this->broadcastService->scheduleBroadcast(
                $broadcast, 
                new \DateTime($request->scheduled_at)
            );
        }

        return redirect()->route('broadcasts.show', $broadcast)
            ->with('success', 'Pesan broadcast berhasil diperbarui.');
    }

    /**
     * Remove the specified broadcast message
     */
    public function destroy(BroadcastMessage $broadcast): RedirectResponse
    {
        if (!$broadcast->canBeDeleted()) {
            return redirect()->route('broadcasts.show', $broadcast)
                ->with('error', 'Pesan broadcast tidak dapat dihapus karena sudah dikirim.');
        }

        $broadcast->delete();

        return redirect()->route('broadcasts.index')
            ->with('success', 'Pesan broadcast berhasil dihapus.');
    }

    /**
     * Send broadcast message immediately
     */
    public function send(BroadcastMessage $broadcast): RedirectResponse
    {
        if (!$broadcast->canBeSent()) {
            return redirect()->route('broadcasts.show', $broadcast)
                ->with('error', 'Pesan broadcast tidak dapat dikirim.');
        }

        $result = $this->broadcastService->sendBroadcast($broadcast);

        if ($result['success']) {
            return redirect()->route('broadcasts.show', $broadcast)
                ->with('success', "Pesan broadcast berhasil dikirim ke {$result['sent_count']} mahasiswa.");
        } else {
            return redirect()->route('broadcasts.show', $broadcast)
                ->with('error', 'Gagal mengirim pesan broadcast: ' . $result['message']);
        }
    }

    /**
     * Test broadcast message
     */
    public function test(Request $request, BroadcastMessage $broadcast): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'test_phone' => 'required|string|regex:/^62\d{9,13}$/',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $result = $this->broadcastService->testBroadcast($broadcast, $request->test_phone);

        if ($result['success']) {
            return redirect()->route('broadcasts.show', $broadcast)
                ->with('success', 'Test broadcast berhasil dikirim.');
        } else {
            return redirect()->route('broadcasts.show', $broadcast)
                ->with('error', 'Test broadcast gagal: ' . $result['error']);
        }
    }


    /**
     * Get recipient preview
     */
    public function previewRecipients(Request $request)
    {
        $targetType = $request->target_type;
        
        \Log::info('Preview recipients request', [
            'target_type' => $targetType,
            'selected_students_raw' => $request->selected_students,
            'all_request_data' => $request->all()
        ]);
        
        if ($targetType === 'specific') {
            // Get specific students
            $selectedStudents = json_decode($request->selected_students, true) ?? [];
            $studentIds = array_column($selectedStudents, 'id');
            
            \Log::info('Specific students processing', [
                'selected_students' => $selectedStudents,
                'student_ids' => $studentIds
            ]);
            
            $recipients = User::whereIn('id', $studentIds)
                ->where('is_active', true)
                ->whereNotNull('phone')
                ->where('phone', '!=', '')
                ->select('id', 'name', 'phone', 'department', 'program', 'institution')
                ->get();
        } else {
            // Get all students
            $recipients = User::where('is_active', true)
                ->where('role', 'student')
                ->whereNotNull('phone')
                ->where('phone', '!=', '')
                ->select('id', 'name', 'phone', 'department', 'program', 'institution')
                ->get();
        }

        return response()->json([
            'success' => true,
            'count' => $recipients->count(),
            'recipients' => $recipients->take(10), // Show first 10 as preview
        ]);
    }

    /**
     * Get all students for selection
     */
    public function getStudents()
    {
        $students = User::where('is_active', true)
            ->where('role', 'student')
            ->whereNotNull('phone')
            ->where('phone', '!=', '')
            ->select('id', 'name', 'phone', 'department', 'program', 'institution')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'students' => $students
        ]);
    }

    /**
     * Get all students for selection (public method for testing)
     */
    public function getStudentsPublic()
    {
        $students = User::where('is_active', true)
            ->where('role', 'student')
            ->whereNotNull('phone')
            ->where('phone', '!=', '')
            ->select('id', 'name', 'phone', 'department', 'program', 'institution')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'students' => $students
        ]);
    }
}
