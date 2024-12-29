<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use App\Models\Team;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TeamPerformanceChart extends ChartWidget
{
    protected static ?string $heading = 'Team Performance Analysis';
    protected static ?int $sort = 4;

    public static function canView(): bool
    {

        return Auth::check() && (Auth::user()->hasRole('Admin') );
    }
    protected function getData(): array
    {

        $teamNames = Team::pluck('name', 'id')->toArray();


        $teamTaskCounts = Task::selectRaw('team_id, COUNT(*) as task_count')
            ->groupBy('team_id')
            ->orderByDesc('task_count')
            ->get();


        $teamTaskStatus = Task::selectRaw('team_id, status, COUNT(*) as status_count')
            ->groupBy('team_id', 'status')
            ->get();


        $teamOverdueTasks = Task::selectRaw('team_id, COUNT(*) as overdue_count')

            ->where('status', '!=', 'complete')
            ->groupBy('team_id')
            ->get();


        $teamCompletionTimes = Task::selectRaw('team_id, AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_completion_time')
            ->where('status', 'complete')
            ->groupBy('team_id')
            ->get();


        $teamLabels = [];
        $totalTaskData = [];
        $completedTaskData = [];
        $pendingTaskData = [];
        $inProgressTaskData = [];
        $overdueTaskData = [];
        $avgCompletionData = [];

        foreach ($teamNames as $teamId => $teamName) {
            $teamLabels[] = $teamName;


            $totalTaskData[] = $teamTaskCounts->firstWhere('team_id', $teamId)->task_count ?? 0;


            $completedTaskData[] = $teamTaskStatus->where('team_id', $teamId)->where('status', 'complete')->sum('status_count');
            $pendingTaskData[] = $teamTaskStatus->where('team_id', $teamId)->where('status', 'pending')->sum('status_count');
            $inProgressTaskData[] = $teamTaskStatus->where('team_id', $teamId)->where('status', 'in progress')->sum('status_count');


            $overdueTaskData[] = $teamOverdueTasks->firstWhere('team_id', $teamId)->overdue_count ?? 0;


            $avgCompletionData[] = round($teamCompletionTimes->firstWhere('team_id', $teamId)->avg_completion_time ?? 0, 2);
        }


        $datasets = [
            [
                'label' => 'Total Tasks',
                'data' => $totalTaskData,
                'backgroundColor' => 'rgba(29, 78, 216, 0.5)',
                'borderColor' => '#1D4ED8',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Completed Tasks',
                'data' => $completedTaskData,
                'backgroundColor' => 'rgba(16, 185, 129, 0.5)',
                'borderColor' => '#10B981',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Pending Tasks',
                'data' => $pendingTaskData,
                'backgroundColor' => 'rgba(234, 179, 8, 0.5)',
                'borderColor' => '#EAB308',
                'borderWidth' => 1,
            ],
            [
                'label' => 'In Progress Tasks',
                'data' => $inProgressTaskData,
                'backgroundColor' => 'rgba(0, 0, 0)',
                'borderColor' => '#3B82F6',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Overdue Tasks',
                'data' => $overdueTaskData,
                'backgroundColor' => 'rgba(220, 38, 38, 0.5)',
                'borderColor' => '#DC2626',
                'borderWidth' => 1,
            ],
        ];

        return [
            'datasets' => $datasets,
            'labels' => $teamLabels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
