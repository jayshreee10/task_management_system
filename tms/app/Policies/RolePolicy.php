<?php
namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;


    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user->hasRole('Admin');
    }

    public function create(User $user)
    {
        return !$user->hasRole('Admin');
    }

    public function assign(User $user)
    {
        return $user->hasRole('Admin');
    }

    public function view(User $user): bool
    {
        return $user->can('view_role');
    }

    public function update(User $user)
    {
        return $user->hasRole('Admin');
    }

    public function delete(User $user)
    {
        return $user->hasRole('Admin');
    }
}
