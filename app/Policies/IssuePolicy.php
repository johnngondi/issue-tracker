<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return bool
     */
    public function view(User $user, Issue $issue): bool
    {
        if ($user->hasRole('admin')){
            return true;
        } else {
            return !($issue->user_id == null) && $issue->user->id === $user->id;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'developer']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return bool
     */
    public function update(User $user, Issue $issue): bool
    {
        return $user->hasRole('admin') || $user->id === $issue->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return bool
     */
    public function delete(User $user, Issue $issue): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return bool
     */
    public function restore(User $user, Issue $issue): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Issue $issue
     * @return bool
     */
    public function forceDelete(User $user, Issue $issue): bool
    {
        return $user->hasRole('admin');
    }
}
