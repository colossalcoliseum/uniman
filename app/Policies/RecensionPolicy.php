<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Enums\UserType;
use App\Models\Recension;
use App\Models\User;

class RecensionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === UserRole::ADMIN ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true)
            || $user->type === UserType::TEACHER->value;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Recension $recension): bool
    {
        return $recension->reviewer_id === $user->id
            || in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->type === UserType::TEACHER->value;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Recension $recension): bool
    {
        return $recension->reviewer_id === $user->id;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Recension $recension): bool
    {
        return $recension->reviewer_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Recension $recension): bool
    {
        return $recension->reviewer_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Recension $recension): bool
    {
        return false;
    }
}
