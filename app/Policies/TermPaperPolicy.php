<?php

namespace App\Policies;

use App\Enums\TermPaperStatus;
use App\Enums\UserRole;
use App\Enums\UserType;
use App\Models\TermPaper;
use App\Models\User;

class TermPaperPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TermPaper $termPaper): bool
    {
        return $termPaper->teacher_id === $user->id
            || $termPaper->student_id === $user->id
            || ($user->type === UserType::STUDENT && $termPaper->student_id === null)
            || $termPaper->recensions()->where('reviewer_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [UserRole::ASSOCIATE_PROFESSOR, UserRole::PROFESSOR], true);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TermPaper $termPaper): bool
    {
        return $termPaper->teacher_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TermPaper $termPaper): bool
    {
        return $termPaper->teacher_id === $user->id ||
            in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true);

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TermPaper $termPaper): bool
    {
        return $termPaper->teacher_id === $user->id ||
            in_array($user->role, [UserRole::RECTOR, UserRole::DEAN], true);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TermPaper $termPaper): bool
    {
        return false;
    }

    public function claim(User $user, TermPaper $termPaper): bool
    {
        return $user->type === UserType::STUDENT
            && $termPaper->student_id === null
            && $termPaper->status === TermPaperStatus::AVAILABLE;
    }
}
