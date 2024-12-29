<?php

namespace App\Filament\Resources\TeamResource\Pages;

use App\Filament\Resources\TeamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditTeam extends EditRecord
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        // Show delete action only to admin and manager roles
        return [
            Actions\DeleteAction::make()->visible(fn () => in_array(Auth::user()->role, ['Admin', 'Manager'])),
        ];
    }


    // /**
    //  * Restrict access to the edit page for unauthorized users.
    //  */
    // protected function authorize(): void
    // {

    //     if (!in_array(Auth::user()->role, ['Admin', 'Manager'])) {
    //         abort(403, 'Unauthorized');
    //     }
    // }
}
