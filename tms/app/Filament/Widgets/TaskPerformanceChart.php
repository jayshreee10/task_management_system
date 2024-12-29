<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskPerformanceChart extends ChartWidget
{
    protected static ?string $heading = 'Task Performance';
    protected static ?int $sort = 3;

    public static function canView(): bool
    {

        return Auth::check() && (Auth::user()->hasRole('Admin') );
    }
    protected function getData(): array
    {

        $userId = auth()->id();


        $tasksByDate = Task::selectRaw('MONTH(created_at) as month, COUNT(*) as tasks_count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();


        $tasksCount = $tasksByDate->pluck('tasks_count')->toArray();
        $months = [
           'Oct','Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'
        ];


        $taskData = array_fill(0, 12, 0);
        foreach ($tasksByDate as $task) {
            $taskData[$task->month - 1] = $task->tasks_count;
        }


        $completedTasks = Task::where('assigned_to', $userId)
            ->where('status', 'completed')
            ->count();

        $totalTasks = Task::where('assigned_to', $userId)->count();

        $completionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        $overdueTasks = Task::where('assigned_to', $userId)
        ->where('status', '!=', 'completed')
        ->where('due_date', '<', Carbon::now())
        ->get();



        return [
            'datasets' => [
                [
                    'label' => 'Tasks Created',
                    'data' => $taskData,
                    'borderColor' => '#1D4ED8',
                    'backgroundColor' => 'rgba(29, 78, 216, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
