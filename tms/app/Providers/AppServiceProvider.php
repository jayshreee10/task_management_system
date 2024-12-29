<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use App\Filament\Widgets\UserTaskWidget;
use Illuminate\Support\Facades\Artisan;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        Filament::registerWidgets([
            UserTaskWidget::class,
        ]);

        if (now()->format('H:i') == '08:00') {
            Artisan::call('tasks:check-due-dates');
        }
    }
}
