<?php


namespace App\Helpers\Classes;

use App\Models\System;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class Systems
{
    /**
     * Get Systems accessible to User
     *
     * @return System[]|Collection|mixed
     */
    public static function getAccessibleByUser()
    {
        $user = user();

        //get systems accessible by user
        if ($user->hasRole('admin')) {
            //get all systems
            $systems = System::all();
        } else {
            // get systems assigned to user
            $systems = $user->systems;
        }

        return self::formatSystems($systems);
    }

    /**
     * Format Systems received.
     * This will get issues associated with it, i.e done, unassigned
     *
     * @param System[]|Collection $systems
     */
    private static function formatSystems( $systems )
    {
        return $systems->map(function (System $system) {
            return [
                'info' => $system->makeHidden(['user_id', 'pivot', 'issues', 'users', 'tags']),
                'users' => $system->users->makeHidden(['email', 'email_verified_at', 'current_team_id',
                    'created_at', 'updated_at', 'id']),
                'tags' => $system->tags->pluck('name')->all(),
                'doneIssuesCount' => $system->issues->where('status', 5)->count(),
                'assignedIssuesCount' => $system->issues->where('status', 1)->count(),
                'unAssignedIssuesCount' => $system->issues->where('status', 0)->count(),
                'rejectedIssuesCount' => $system->issues->where('status', 6)->count(),
            ];
        });
    }

    /**
     * Get system developers
     *
     * @param System $system
     * @return User[] | Collection
     */
    public static function getDevelopers(System $system)
    {
            list($developers) = $system->users->partition(function(User $user) {
                return $user->hasRole('developer');
            });

            return $developers;
    }
}
