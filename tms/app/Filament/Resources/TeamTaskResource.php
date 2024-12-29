<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamTaskResource\Pages;
use App\Models\Task;
use App\Models\User;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class TeamTaskResource extends Resource
{
    protected static ?string $model = Task::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Team Tasks';
    protected static ?string $slug = 'team-tasks';


    public static function getModelLabel(): string
    {
        return 'Team Task';
    }



    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->label('Task Title'),

            Forms\Components\Textarea::make('description')
                ->label('Task Description'),

            Forms\Components\Select::make('assigned_to')
                ->options(
                    User::query()
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'Team Member');
                        })
                        ->pluck('name', 'id')
                )
                ->label('Assign To'),

            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'in progress' => 'In Progress',
                    'complete' => 'Complete',
                ])
                ->default('pending')
                ->required()
                ->label('Task Status'),

                Forms\Components\DatePicker::make('due_date')
                ->label('Due Date')
                ->disabled(fn () => auth()->user()->hasRole('Team Member'))
                ->minDate(now()->toDateString())
                ->required()
                ->helperText('The due date must be today or in the future.')  ,

            Forms\Components\Select::make('created_by')
                ->options(
                    User::query()
                        ->whereHas('roles', function ($query) {
                            $query->whereIn('name', ['Admin', 'Manager']);
                        })
                        ->where('id', auth()->id())
                        ->pluck('name', 'id')
                )
                ->label('Created By')
                ->default(auth()->id())
                ->nullable(),

            Forms\Components\Select::make('priority')
                ->options([
                    'High' => 'High',
                    'Medium' => 'Medium',
                    'Low' => 'Low',
                ])
                ->default('Low')
                ->required()
                ->label('Priority'),

            Forms\Components\Select::make('team_id')
                ->relationship('team', 'name')
                ->required(),
        ]);
    }
    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->query(Team::query())  // This is the query for fetching teams
    //         ->columns([
    //             TextColumn::make('name')->label('Task Assigned Teams'),
    //         ])
    //         ->actions([
    //             Action::make('view')
    //                 ->label('View')
    //                 ->icon('heroicon-o-information-circle')

    //                 ->url(fn (Team $record) => static::getUrl('view', ['record' => $record->id])),
    //             // EditAction::make()
    //             //     ->visible(fn () => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
    //             // DeleteAction::make()
    //             //     ->visible(fn () => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
    //         ]);
    // }
    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Team::query()
                    ->when(!auth()->user()->hasRole('Admin'), function ($query) {
                        // For Team Members and Managers, only show teams that have tasks
                        $query->whereHas('tasks', function ($taskQuery) {
                            $taskQuery->when(auth()->user()->hasRole('Team Member'), function ($subQuery) {
                                // For Team Members, further filter tasks assigned to the current user
                                $subQuery->where('assigned_to', auth()->id());
                            });
                        });
                    })
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Team Name'),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-information-circle')
                    ->url(fn (Team $record) => static::getUrl('view', ['record' => $record->id])),
                // EditAction::make()
                //     ->visible(fn () => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
                // DeleteAction::make()
                //     ->visible(fn () => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
            ]);
    }




    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeamTasks::route('/'),
            'create' => Pages\CreateTeamTask::route('/create'),
            'edit' => Pages\EditTeamTask::route('/{record}/edit'),
            'view' => Pages\ViewTeamTaskAdmin::route('/{record}/view'),

        ];
    }

}
