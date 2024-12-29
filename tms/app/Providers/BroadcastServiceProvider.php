<?php
namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register the channel for broadcasting events
        Broadcast::channel('my-channel', function ($user) {
            // Optionally, you could add authorization logic here, but for now, it broadcasts to all authenticated users.
            return $user !== null; // Only authenticated users can listen to 'my-channel'
        });
    }
}
