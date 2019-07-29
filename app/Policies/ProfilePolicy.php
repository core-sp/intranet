<?php

namespace App\Policies;

use App\User;
use App\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;
    
    public function create(User $user, Profile $profile)
    {
        return $user->isAdmin();
    }
}
