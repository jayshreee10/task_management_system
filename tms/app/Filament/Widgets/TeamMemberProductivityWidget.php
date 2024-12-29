<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use App\Models\TeamTask;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class TeamMemberProductivityWidget extends ChartWidget
{
    protected static ?string $heading = 'Member Productivity';
    protected static ?int $sort = 3;

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->hasRole('Team Member') || Auth::user()->hasRole('Manager');
    }


    protected function getData(): array
    {
        $userId = Auth::id();


        $totalIndividualTasks = Task::where('assigned_to', $userId)->count();
        $completedIndividualTasks = Task::where('assigned_to', $userId)
            ->where('status', 'complete')
            ->count();


        $teamId = Task::where('assigned_to', $userId)->value('team_id');


        $totalTeamTasks = Task::where('team_id', $teamId)->count();
        $completedTeamTasks = Task::where('team_id', $teamId)
            ->where('status', 'complete')
            ->count();


        $individualCompletionRate = $totalIndividualTasks > 0
            ? round(($completedIndividualTasks / $totalIndividualTasks) * 100, 2)
            : 0;

        $teamCompletionRate = $totalTeamTasks > 0
            ? round(($completedTeamTasks / $totalTeamTasks) * 100, 2)
            : 0;

        return [
            'datasets' => [
                [
                    'label' => 'Productivity',
                    'data' => [
                        $individualCompletionRate,
                        $teamCompletionRate,
                        100 - ($individualCompletionRate + $teamCompletionRate)
                    ],
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(229, 231, 235, 0.7)',
                    ],
                    'borderColor' => [
                        'rgba(34, 197, 94, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(209, 213, 219, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Individual Tasks', 'Team Tasks', 'Remaining'],
        ];
    }


    protected function getType(): string
    {
        return 'doughnut';
    }
}
