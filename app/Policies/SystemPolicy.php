<?php /** @noinspection PhpUnusedParameterInspection */

namespace App\Policies;

use App\Models\System;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemPolicy
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
     * @param System $system
     * @return bool
     */
    public function view(User $user, System $system): bool
    {
        if ($user->hasRole('admin')){
            return true;
        } else {
            return ($system->users->contains($user));
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
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param System $system
     * @return bool
     */
    public function update(User $user, System $system): bool
    {
        if ($user->hasRole('admin')){
            return true;
        } else {
            return ($system->users->contains($user));
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param System $system
     * @return bool
     */
    public function delete(User $user, System $system): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param System $system
     * @return bool
     */
    public function restore(User $user, System $system): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param System $system
     * @return bool
     */
    public function forceDelete(User $user, System $system): bool
    {
        return $user->hasRole('admin');
    }
}
