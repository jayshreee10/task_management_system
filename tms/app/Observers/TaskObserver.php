<?php
namespace App\Observers;

use App\Models\Task;
use App\Mail\NewTaskCreatedForUser;
use App\Mail\TaskStatusUpdatedForUser;
use Illuminate\Support\Facades\Mail;

class TaskObserver
{

    public function created(Task $task)
    {

        if ($task->assignedUser) {
            Mail::to($task->assignedUser->email)->send(new NewTaskCreatedForUser($task));

        }
    }


    public function updated(Task $task)
    {

        if ($task->assignedUser) {
            Mail::to($task->assignedUser->email)->send(new TaskStatusUpdatedForUser($task));
        }
    }
}
