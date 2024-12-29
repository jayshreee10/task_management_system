<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Events\TaskUpdated;
use Filament\Resources\Pages\EditRecord;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;
    protected function afterUpdate(): void
    {
        $task = $this->record;
        event(new TaskUpdated($task));
    }
}
