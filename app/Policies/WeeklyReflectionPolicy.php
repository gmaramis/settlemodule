<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeeklyReflection;
use Illuminate\Auth\Access\Response;

class WeeklyReflectionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->is_admin || $user->is_supervisor || $user->is_student;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WeeklyReflection $weeklyReflection): bool
    {
        return $user->is_admin || 
               $user->id === $weeklyReflection->user_id ||
               $user->is_supervisor;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_student || $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WeeklyReflection $weeklyReflection): bool
    {
        return $user->is_admin || 
               $user->id === $weeklyReflection->user_id ||
               $user->is_supervisor;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WeeklyReflection $weeklyReflection): bool
    {
        return $user->is_admin || $user->is_supervisor;
    }

    /**
     * Determine whether the user can review the model.
     */
    public function review(User $user, WeeklyReflection $weeklyReflection): bool
    {
        return $user->is_supervisor || $user->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WeeklyReflection $weeklyReflection): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WeeklyReflection $weeklyReflection): bool
    {
        return false;
    }
}
