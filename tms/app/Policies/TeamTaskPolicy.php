<?php
namespace App\Policies;

use App\Models\TeamTask;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamTaskPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['Admin', 'Manager', 'Team Member']);
    }


    public function view(User $user, TeamTask $teamTask)
    {

        return $user->hasAnyRole(['Admin', 'Manager', 'Team Member']);
    }


    public function create(User $user)
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }


    public function update(User $user, TeamTask $teamTask)
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }


    public function delete(User $user, TeamTask $teamTask)
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }
}
