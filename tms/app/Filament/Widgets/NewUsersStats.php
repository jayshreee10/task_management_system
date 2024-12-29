<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NewUsersStats extends StatsOverviewWidget
{
    protected  ?string $heading = 'New Users Overview';
    protected static ?int $sort = 2;

    public static function canView(): bool
    {

        return Auth::check() && (Auth::user()->hasRole('Admin') );
    }

    protected function getCards(): array
    {
        $totalUsers = User::count();

        $usersLast7Days = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        $usersThisMonth = User::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $usersThisYear = User::whereYear('created_at', Carbon::now()->year)->count();

        return [
            Card::make('Total Users', $totalUsers)
                ->description('Total users in the system')
                ->icon('heroicon-o-users'),

            Card::make('New Users (Last 7 Days)', $usersLast7Days)
                ->description('Users added in the last 7 days')
                ->chart([0, $usersLast7Days]) // Chart example for trend visualization
                ->color('success'),

            Card::make('New Users (This Month)', $usersThisMonth)
                ->description('Users added this month')
                ->color('primary'),

            Card::make('New Users (This Year)', $usersThisYear)
                ->description('Users added this year')
                ->color('info'),
        ];
    }
}
