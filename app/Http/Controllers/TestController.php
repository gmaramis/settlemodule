<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Get all students for testing
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
}
