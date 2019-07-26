<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->isAdmin();
    }
    
    public function create(User $user)
    {
        return $user->isAdmin();
    }
}
