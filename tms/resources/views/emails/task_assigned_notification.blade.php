<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task Assigned</title>
</head>
<body>
    <h1>New Task Assigned: {{ $task->title }}</h1>

    <p>Dear {{ $assignedUser->name }},</p>

    <p>You have been assigned a new task titled "<strong>{{ $task->title }}</strong>".</p>

    <p><strong>Task Details:</strong></p>
    <ul>
        <li><strong>Title:</strong> {{ $task->title }}</li>
        <li><strong>Description:</strong> {{ $task->description }}</li>
        <li><strong>Status:</strong> {{ ucfirst($task->status) }}</li>
        <li><strong>Due Date:</strong> {{ $task->due_date }}</li>
        <li><strong>Priority:</strong> {{ $task->priority }}</li>
    </ul>

    <p>This task was created by {{ $assignedBy->name }}.</p>

    <p>Please log in to the task management system to view and work on your tasks.</p>

    <p>Thank you!</p>
</body>
</html>
