<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Only check for students
        if ($user && $user->role === 'student') {
            // Check if profile is incomplete
            $isIncomplete = empty($user->student_id) || 
                           empty($user->phone) || 
                           empty($user->date_of_birth) ||
                           empty($user->emergency_contact_name) ||
                           empty($user->emergency_contact_phone);
            
            if ($isIncomplete && !$request->session()->has('profile_completion_reminder_shown')) {
                $request->session()->flash('profile_completion_reminder', true);
                $request->session()->put('profile_completion_reminder_shown', true);
            }
        }
        
        return $next($request);
    }
}
