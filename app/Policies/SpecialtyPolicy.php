<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Specialty;
use App\Models\User;

class SpecialtyPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === UserRole::ADMIN ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Specialty $specialty): bool
    {
        return in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Specialty $specialty): bool
    {
        return in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Specialty $specialty): bool
    {
        return in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Specialty $specialty): bool
    {
        return in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Specialty $specialty): bool
    {
        return false;
    }
}
