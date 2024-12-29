<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserPerformanceChart extends ChartWidget
{
    protected static ?string $heading = 'User Performance Analytics';
    protected static ?int $sort = 5;


    public static function canView(): bool
    {

        return Auth::check() && (Auth::user()->hasRole('Admin') );
    }

    protected function getData(): array
    {

        $users = User::pluck('name', 'id');


        $userCompletionRates = [];
        $userOverdueTasks = [];
        $userLabels = [];


        foreach ($users as $userId => $userName) {

            $totalTasks = Task::where('assigned_to', $userId)->count();
            // $totalTasks = rand(5, $userId);

            $completedTasks = Task::where('assigned_to', $userId)
                ->where('status','complete')
                ->count();


            $overdueTasks = Task::where('assigned_to', $userId)
                ->where('status', '!=', 'complete')
                ->count();


            $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;


            $userCompletionRates[] = $completionRate;
            $userOverdueTasks[] = $overdueTasks;
            $userLabels[] = $userName;
        }


        \Log::info("User Completion Rates: ", $userCompletionRates);
        \Log::info("User Overdue Tasks: ", $userOverdueTasks);
        \Log::info("User Labels: ", $userLabels);

        $datasets = [
            [
                'label' => 'Task Completion Rate (%)',
                'data' => $userCompletionRates,
                'backgroundColor' => 'rgba(34, 197, 94, 0.7)', // Green for completion
                'borderColor' => 'rgba(34, 197, 94, 1)',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Overdue Tasks',
                'data' => $userOverdueTasks,
                'backgroundColor' => 'rgba(239, 68, 68, 0.7)', // Red for overdue
                'borderColor' => 'rgba(239, 68, 68, 1)',
                'borderWidth' => 1,
            ],
        ];


        return [
            'datasets' => $datasets,
            'labels' => $userLabels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
