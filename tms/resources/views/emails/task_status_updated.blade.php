<!-- resources/views/emails/task_status_updated.blade.php -->

<p>Hello {{ $assignedUser->name }},</p>

<p>The task titled "{{ $task->title }}" has been updated. The new status is "{{ $task->status }}".</p>

<p>Assigned By: {{ $assignedBy->name }}</p>
<p>Priority: {{ $task->priority }}</p>
<p>Due Date: {{ $task->due_date }}</p>

<p>Regards,</p>
<p>Your Task Management System</p>

