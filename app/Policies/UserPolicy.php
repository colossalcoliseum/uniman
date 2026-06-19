<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Institution;
use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function before(User $user, string $ability): bool|null
    {
        return $user->role === UserRole::ADMIN ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->is($model) || $this->hasViewPrivileges($user, $model);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->is($model) || $this->hasViewPrivileges($user, $model);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->is($model)) {
            return false;
        }
         return $this->hasViewPrivileges($user, $model);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $this->hasViewPrivileges($user, $model);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    public function hasViewPrivileges(User $user, User $model): bool
    {
        if ($user->role !== UserRole::RECTOR) {
            return false;
        }

        return Institution::where('manager_id', $user->id)
            ->whereHas('faculties', function ($query) use ($model) {
                $query->where('dean_id', $model->id);
            })
            ->exists();

    }
}
