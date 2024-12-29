<?php
namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;
class TaskCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    public function __construct(Task $task)

    {
        $this->task = $task;
        $assignedTo = $task->assigned_to; 
        Log::info('TaskCreated event initialized', ['task' => $task]);
        $pusher = new Pusher("ad01d9f2e3e21cd28d10", "6e3ead48a77190fbd388", "1914801", array('cluster' => 'ap2'));

        $pusher->trigger("{$assignedTo}", 'task.created', ['message' => 'Task Created']);

    }


    public function broadcastOn()
    {

    }


}

