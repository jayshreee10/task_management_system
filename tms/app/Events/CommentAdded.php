<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Pusher\Pusher;
use Illuminate\Support\Facades\Log;

class CommentAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    public function __construct(Task $task)

    {
        $this->task = $task;
      
        $assignedTo = $task->assigned_to; 
       
        Log::info('Comment Added event initialized', ['task' => $task]);
       
        $pusher = new Pusher("ad01d9f2e3e21cd28d10", "6e3ead48a77190fbd388", "1914801", array('cluster' => 'ap2'));

        $pusher->trigger("{$assignedTo}", 'comment.added', ['message' => 'Comment Added']);

    }

    public function broadcastOn()
    {
        
    }

 
    
}
