<?php


namespace App\Helpers\Classes;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class Users
{

    /**
     * Get all the system Developers available
     *
     * @return User[] | Collection | object
     */
    public static function getDevelopers()
    {
        return self::getRoleUsers('developer')   ;
    }


    /**
     * Get users with a certain role(s)
     *
     * @param string | array $roles
     */
    public static function getRoleUsers($roles)
    {
        list($needed) = User::all()->partition(function(User $user) use ($roles) {
            return $user->hasRole($roles);
        });

        return $needed;
    }

}
