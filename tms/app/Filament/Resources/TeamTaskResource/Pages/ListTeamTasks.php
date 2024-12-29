<?php

namespace App\Filament\Resources\TeamTaskResource\Pages;

use App\Filament\Resources\TeamTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeamTasks extends ListRecords
{
    protected static string $resource = TeamTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
