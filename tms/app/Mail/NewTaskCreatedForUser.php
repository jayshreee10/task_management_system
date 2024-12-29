<?php

namespace App\Mail;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewTaskCreatedForUser extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $assignedUser;
    public $assignedBy;


    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->assignedUser = $task->assignedUser;
        $this->assignedBy = $task->createdBy;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Task Assigned: ' . $this->task->title,
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.task_assigned_notification',
            with: [
                'task' => $this->task,
                'assignedUser' => $this->assignedUser,
                'assignedBy' => $this->assignedBy,
            ],
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
