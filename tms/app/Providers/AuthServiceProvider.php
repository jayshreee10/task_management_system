<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Policies\TaskPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Task::class => TaskPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Team::class => TeamPolicy::class,
    ];


    public function boot(): void
    {
        $this->registerPolicies();


        Gate::define('create-task', [TaskPolicy::class, 'create']);
        Gate::define('assign-task', [TaskPolicy::class, 'assign']);
        Gate::define('view-task', [TaskPolicy::class, 'view']);
        Gate::define('update-task', [TaskPolicy::class, 'update']);
        Gate::define('delete-task', [TaskPolicy::class, 'delete']);
        Gate::define('create-team', [TeamPolicy::class, 'create']);
        Gate::define('update-team', [TeamPolicy::class, 'update']);
        Gate::define('delete-team', [TeamPolicy::class, 'delete']);
        Gate::policy(User::class, UserPolicy::class);
    }
}
