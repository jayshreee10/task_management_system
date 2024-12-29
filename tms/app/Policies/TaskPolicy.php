<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;


    public function create(User $user)
    {

        return $user->hasRole('Admin') || $user->hasRole('Manager');
    }


    public function assign(User $user)
    {

        return $user->hasRole('Admin') || $user->hasRole('Manager');
    }


    public function view(User $user, Task $task)
    {

        return $user->hasRole('Admin') || $user->hasRole('Manager') || $user->id === $task->assigned_to;
    }


    public function update(User $user, Task $task)
    {

        return $user->hasRole('Admin') || $user->hasRole('Manager') || $user->id === $task->assigned_to;
    }


    public function delete(User $user, Task $task)
    {

        return $user->hasRole('Admin');
    }
}
