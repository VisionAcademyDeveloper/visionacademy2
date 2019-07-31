<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;


    public function isTeacher(User $user)
    {
        return $user->user_type == 'teacher';
        // return false;
    }
}
