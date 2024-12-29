<?php

namespace App\Filament\Resources\TeamTaskResource\Pages;

use App\Filament\Resources\TeamTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeamTask extends EditRecord
{
    protected static string $resource = TeamTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
