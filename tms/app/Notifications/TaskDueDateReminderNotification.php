<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TaskDueDateReminderNotification extends Notification
{
    use Queueable;

    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    public function toDatabase($notifiable)
    {
        $status = $this->getNotificationStatus();

        return [
            'id' => Str::uuid()->toString(),
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'due_date' => $this->task->due_date,
            'message' => $this->getNotificationMessage($status),
            'type' => $status
        ];
    }

    private function getNotificationStatus()
    {
        $dueDate = Carbon::parse($this->task->due_date);
        $today = Carbon::today();

        if ($dueDate->isPast()) {
            return 'overdue';
        }

        if ($dueDate->isToday()) {
            return 'due_today';
        }

        if ($dueDate->diffInDays($today) <= 2) {
            return 'approaching';
        }

        return 'upcoming';
    }

    private function getNotificationMessage($status)
    {
        switch ($status) {
            case 'overdue':
                return "Task '{$this->task->title}' is overdue!";
            case 'due_today':
                return "Task '{$this->task->title}' is due today!";
            case 'approaching':
                return "Task '{$this->task->title}' is approaching its due date.";
            default:
                return "Reminder about task '{$this->task->title}'.";
        }
    }



public function toBroadcast($notifiable)
{
    $status = $this->getNotificationStatus();

    return new BroadcastMessage([
        'id' => Str::uuid()->toString(),
        'task_id' => $this->task->id,
        'title' => $this->task->title,
        'due_date' => $this->task->due_date,
        'message' => $this->getNotificationMessage($status),
        'type' => $status,
    ]);
}

}
