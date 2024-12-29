<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\Widget;


class UserTaskWidget extends Widget
{
    protected static string $view = 'filament.widgets.user-task-widget';

    public function getData(): array
    {
        $user = auth()->user();


        if ($user->hasRole('Admin') || $user->hasRole('Manager')) {

            $tasks = Task::query()
                ->with('assignedTo')
                ->orderBy('due_date')
                ->get();
        } else
        if ($user->hasRole('Team Member')) {

            $tasks = Task::where('assigned_to', $user->id)
                ->orderBy('due_date')
                ->get();
        } else {
            $tasks = collect();
        }

        return [
            'tasks' => $tasks,
        ];
    }
}

