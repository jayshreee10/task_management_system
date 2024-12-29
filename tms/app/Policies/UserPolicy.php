<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    public function create(User $user): bool
    {
        return $user->hasRole('Admin');

    }

    // public function update(User $authUser, User $user)
    // {
    //     return $user->hasRole('Admin');
    // }

    public function delete( User $user)
{
    return $user->hasRole('Admin');
}


}
