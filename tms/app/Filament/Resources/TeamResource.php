<?php

namespace App\Filament\Resources;

use App\Models\Team;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\MultiSelect;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Split;
use App\Filament\Resources\TeamResource\Pages;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Support\Facades\Auth;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'teams';
    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user->hasRole('Admin') ||
               $user->hasRole('Manager') ||
               $user->teams()->exists();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Team Name')
                    ->required()
                    ->disabled(!auth()->user()->hasAnyRole(['Admin', 'Manager'])),

                Textarea::make('description')
                    ->label('Team Description')
                    ->nullable()
                    ->disabled(!auth()->user()->hasAnyRole(['Admin', 'Manager'])),

                MultiSelect::make('members')
                    ->label('Members')
                    ->relationship('users', 'name')
                    ->multiple()
                    ->required()
                    ->disabled(!auth()->user()->hasAnyRole(['Admin', 'Manager'])),

                MultiSelect::make('leads')
                    ->label('Leads')
                    ->relationship('users', 'name')
                    ->multiple()
                    ->required()
                    ->disabled(!auth()->user()->hasAnyRole(['Admin', 'Manager'])),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();


        if ($user->hasRole('Admin')) {
            $query = Team::query();
        } else {
            $query = Team::assignedToUser($user);
        }

        return $table
            ->query($query)
            ->columns([
                Split::make([
                    Grid::make()
                        ->schema([
                            Grid::make()
                                ->schema([
                                    TextColumn::make('name')
                                        ->label('Team')
                                        ->getStateUsing(fn (Team $team) => 'Team: ' . $team->name)
                                        ->extraAttributes([
                                            'class' => 'text-xl font-semibold text-gray-900 dark:text-gray-100'
                                        ])
                                        ->columnSpan(2),

                                    TextColumn::make('description')
                                        ->label('Desc')
                                        ->getStateUsing(fn (Team $team) => 'Desc: ' . $team->description)
                                        ->limit(50)
                                        ->extraAttributes([
                                            'class' => 'text-sm text-gray-600 dark:text-gray-300'
                                        ])
                                        ->columnSpan(2),

                                    TextColumn::make('members')
                                        ->label('Members')
                                        ->getStateUsing(fn (Team $team) =>
                                            'Members: ' . (is_array($team->members)
                                                ? implode(', ', \App\Models\User::whereIn('id', $team->members)->pluck('name')->toArray())
                                                : '')
                                        )
                                        ->extraAttributes([
                                            'class' => 'text-sm text-gray-600 dark:text-gray-300'
                                        ])
                                        ->columnSpan(2),

                                    TextColumn::make('leads')
                                        ->label('Leads')
                                        ->getStateUsing(fn (Team $team) =>
                                            'Leads: ' . (is_array($team->leads)
                                                ? implode(', ', \App\Models\User::whereIn('id', $team->leads)->pluck('name')->toArray())
                                                : '')
                                        )
                                        ->extraAttributes([
                                            'class' => 'text-sm text-gray-600 dark:text-gray-300'
                                        ])
                                        ->columnSpan(2),
                                ])
                                ->columns(1),
                        ])
                        ->columns(1),
                ])
            ])
            ->actions([
                EditAction::make()
                    ->visible(fn () => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
                DeleteAction::make()
                    ->visible(fn () => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
            ])
            ->defaultSort('name', 'asc');
    }



    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
