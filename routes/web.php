<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClinicalRotationController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\WeeklyReflectionController;
use App\Http\Controllers\LearningLogController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BroadcastController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Temporary route for testing get-students
Route::get('test-get-students', [App\Http\Controllers\TestController::class, 'getStudents'])->name('test.get-students');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Clinical Rotations
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('clinical-rotations', ClinicalRotationController::class);
    Route::post('clinical-rotations/{clinicalRotation}/start', [ClinicalRotationController::class, 'start'])
        ->name('clinical-rotations.start');
    Route::post('clinical-rotations/{clinicalRotation}/complete', [ClinicalRotationController::class, 'complete'])
        ->name('clinical-rotations.complete');
});

// Incidents
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('incidents', IncidentController::class);
    Route::get('incidents/{incident}/review', [IncidentController::class, 'review'])
        ->name('incidents.review');
    Route::post('incidents/{incident}/review', [IncidentController::class, 'updateReview'])
        ->name('incidents.update-review');
});

// Weekly Reflections
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('weekly-reflections', WeeklyReflectionController::class);
    Route::get('weekly-reflections/{weeklyReflection}/review', [WeeklyReflectionController::class, 'review'])
        ->name('weekly-reflections.review');
    Route::post('weekly-reflections/{weeklyReflection}/review', [WeeklyReflectionController::class, 'updateReview'])
        ->name('weekly-reflections.update-review');
    Route::post('weekly-reflections/{weeklyReflection}/submit', [WeeklyReflectionController::class, 'submit'])
        ->name('weekly-reflections.submit');
});

// Learning Logs
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('learning-logs', LearningLogController::class);
    Route::get('learning-logs/{learningLog}/review', [LearningLogController::class, 'review'])
        ->name('learning-logs.review');
    Route::post('learning-logs/{learningLog}/review', [LearningLogController::class, 'updateReview'])
        ->name('learning-logs.update-review');
    Route::post('learning-logs/{learningLog}/mark-practiced', [LearningLogController::class, 'markPracticed'])
        ->name('learning-logs.mark-practiced');

    // Activity Logs (Admin only)
    Route::middleware('can:admin')->group(function () {
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
        Route::get('activity-logs/export/csv', [ActivityLogController::class, 'export'])->name('activity-logs.export');
        Route::post('activity-logs/cleanup', [ActivityLogController::class, 'cleanup'])->name('activity-logs.cleanup');
    });

    // User Management (Admin only)
    Route::middleware('can:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        
        // Student Management
        Route::resource('students', StudentController::class);
        Route::post('students/{student}/toggle-status', [StudentController::class, 'toggleStatus'])->name('students.toggle-status');
        
        // Broadcast Messages (Admin only)
        Route::resource('broadcasts', BroadcastController::class);
        Route::post('broadcasts/{broadcast}/send', [BroadcastController::class, 'send'])->name('broadcasts.send');
        Route::post('broadcasts/{broadcast}/test', [BroadcastController::class, 'test'])->name('broadcasts.test');
        Route::post('broadcasts/preview/recipients', [BroadcastController::class, 'previewRecipients'])->name('broadcasts.preview-recipients');
        Route::get('broadcasts/get-students', [BroadcastController::class, 'getStudents'])->name('broadcasts.get-students');
        
    });

});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
