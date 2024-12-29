<?php
namespace App\GraphQL\Queries;

use App\Models\Task;

class TasksForUser
{
    public function __invoke($root, array $args)
    {
        $tasks = Task::where('assigned_to', $args['assigned_to'])->get();

        return $tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'due_date' => $task->due_date,
                'created_by' => $task->created_by,
                'priority' => $task->priority,
                'assigned_to' => $task->assigned_to,
                'created_at' => $task->created_at,
                'updated_at' => $task->updated_at,
                'team_id' => $task->team_id,
                'name' => $task->name,
                'comments' => $this->formatComments($task->comments),
            ];
        });
    }

    private function formatComments($comments)
    {
        if (empty($comments)) {
            return [];
        }


        return collect($comments)->map(function ($comment) {
            return [
                'user_id' => $comment['user_id'] ?? null,
                'username' => $comment['username'] ?? null,
                'comment' => $comment['comment'] ?? null,
                'timestamp' => $comment['timestamp'] ?? null,
            ];
        })->toArray();
    }

}
