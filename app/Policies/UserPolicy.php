<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleHasPermission;
use App\Models\Permission;
use App\Models\Organisation;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        // return $user;
        if ($user->permissions()->pluck('id')->contains(1)) {
            return true;
        } else {
            return false;
        }
    }
}
