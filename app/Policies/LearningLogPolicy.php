<?php

namespace App\Policies;

use App\Models\LearningLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LearningLogPolicy
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
    public function view(User $user, LearningLog $learningLog): bool
    {
        return $user->is_admin || 
               $user->id === $learningLog->user_id ||
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
    public function update(User $user, LearningLog $learningLog): bool
    {
        return $user->is_admin || 
               $user->id === $learningLog->user_id ||
               $user->is_supervisor;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LearningLog $learningLog): bool
    {
        return $user->is_admin || $user->is_supervisor;
    }

    /**
     * Determine whether the user can review the model.
     */
    public function review(User $user, LearningLog $learningLog): bool
    {
        return $user->is_supervisor || $user->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LearningLog $learningLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LearningLog $learningLog): bool
    {
        return false;
    }
}
