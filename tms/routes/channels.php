<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:api']]);


Broadcast::channel('private-task.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});


