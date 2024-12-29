<?php

namespace App\Providers;

use App\Models\Task;
use App\Observers\TaskObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use App\Notifications\LoginNotification;
use App\Listeners\SendLoginNotification;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {

        Task::observe(TaskObserver::class);
    }

    protected $listen = [
        Login::class => [
            SendLoginNotification::class,
        ],
    ];
}


