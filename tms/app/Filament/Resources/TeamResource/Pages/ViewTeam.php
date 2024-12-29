<?php
namespace App\Filament\Resources\TeamResource\Pages;

use App\Filament\Resources\TeamResource;
use Filament\Resources\Pages\Page;
use App\Models\Team;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;

class ViewTeam extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = TeamResource::class;
    protected static string $view = 'filament.resources.teams.view';

    public $team;

    public function mount($record)
    {
        $this->team = Team::findOrFail($record);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => $this->team->tasks())
            ->columns([
                TextColumn::make('name')
                    ->label('Task Name')
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->wrap(),
            ])
            ->actions([
                EditAction::make()
                    ->url(fn ($record) => route('filament.resources.teams.view', $record)),
            ]);
    }
}
