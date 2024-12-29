<?php
namespace App\Filament\Widgets;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\Widget;

class UserPerformanceWidget extends BaseWidget
{
    protected ?string $heading = 'My Performance';
    protected static ?int $sort = 2;

    public static function canView(): bool
    {

        return Auth::check() && (Auth::user()->hasRole('Team Member') || Auth::user()->hasRole('Manager'));
    }

    protected function getCards(): array
    {

        if (!Auth::check() || (!Auth::user()->hasRole('Team Member') && !Auth::user()->hasRole('Manager'))) {
            return [];
        }

        $userId = Auth::user()->id;


        \Log::info('Current Authenticated Team Member User ID: ' . $userId);

        $overdueTasks = Task::where('assigned_to', $userId)
            ->where('status', '!=', 'complete')
            ->count();

        $completedTasks = Task::where('assigned_to', $userId)
            ->where('status', 'complete')
            ->count();

        $totalTasks = Task::where('assigned_to', $userId)->count();


        $performance = $totalTasks > 0
            ? round(($completedTasks / $totalTasks) * 100, 2)
            : 0;


        \Log::info('Overdue Tasks for Team Member User ID ' . $userId . ': ' . $overdueTasks);

        return [
            Card::make('Overdue Tasks', $overdueTasks)
                ->description('Tasks overdue')
                ->color('danger'),
            Card::make('Tasks Completed', $completedTasks)
                ->description('Tasks completed successfully')
                ->color('success'),
            Card::make('Performance', $performance . '%')
                ->description('Completion rate')
                ->color('primary'),
        ];
    }
}
