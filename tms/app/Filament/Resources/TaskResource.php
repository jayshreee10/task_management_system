<?php
namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use App\Models\User;
use App\Events\TaskCreated;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'All Tasks';
    protected static ?string $slug = 'tasks';

    public static function getModelLabel(): string
    {
        return 'Tasks';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Task Title')
                ->required()
                ->disabled(fn () => auth()->user()->hasRole('Team Member')),

            Forms\Components\Textarea::make('description')
                ->label('Task Description')
                ->disabled(fn () => auth()->user()->hasRole('Team Member')),

            Forms\Components\Select::make('assigned_to')
                ->options(User::pluck('name', 'id'))
                ->label('Assign To')
                ->disabled(fn () => auth()->user()->hasRole('Team Member')),

            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'in progress' => 'In Progress',
                    'complete' => 'Complete'
                ])
                ->default('pending')
                ->label('Task Status'),

            Forms\Components\DatePicker::make('due_date')
                ->label('Due Date')
                ->disabled(fn () => auth()->user()->hasRole('Team Member'))
                ->minDate(now()->toDateString())
                ->required()
                ->helperText('The due date must be today or in the future.'),

            Forms\Components\Select::make('priority')
                ->options([
                    'High' => 'High',
                    'Medium' => 'Medium',
                    'Low' => 'Low',
                ])
                ->default('Low')
                ->label('Priority')
                ->required()
                ->disabled(fn () => auth()->user()->hasRole('Team Member')),

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
                ->nullable()
                ->hidden(fn () => auth()->user()->hasRole('Team Member')),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Task::query()
                    ->whereNull('team_id')
            )
            ->columns([
                TextColumn::make('title')->label('Task Title'),
                TextColumn::make('priority')->label('Priority')->sortable(),
                TextColumn::make('assignedUser.name')->label('Assigned To'),
                TextColumn::make('status')->label('Status'),
                TextColumn::make('due_date')->label('Due Date'),
                TextColumn::make('createdBy.name')->label('Created By'),
            ])
            ->filters([
                SelectFilter::make('assigned_to')
                    ->label('Assigned User')
                    ->options(
                        User::query()
                            ->whereHas('roles', function ($query) {
                                $query->where('name', 'Team Member');
                            })
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->default(function () {
                        if (auth()->user()->hasRole('Team Member')) {
                            return auth()->user()->id;
                        } elseif (auth()->user()->hasRole('Manager')) {
                            return null;
                        }
                        return null;
                    }),

                SelectFilter::make('created_by')
                    ->label('Created By')
                    ->options(
                        User::query()
                            ->whereHas('roles', function ($query) {
                                $query->whereIn('name', ['Admin', 'Manager']);
                            })
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->default(function () {
                        if (auth()->user()->hasRole('Manager')) {
                            return auth()->user()->id;
                        }
                        return null;
                    }),

                SelectFilter::make('status')
                    ->label('Task Status')
                    ->options([
                        'Pending' => 'Pending',
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                    ]),

                SelectFilter::make('due_date')
                    ->label('Due Date'),

                SelectFilter::make('priority')
                    ->label('Priority')
                    ->options([
                        'High' => 'High',
                        'Medium' => 'Medium',
                        'Low' => 'Low',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn (Model $record) => auth()->user()->hasRole(['Admin', 'Manager'])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {

        $data['created_by'] = auth()->id();


        $task = Task::create($data);


        \Log::info('Task Created Event Fired', ['task' => $task]);


        event(new TaskCreated($task));


        return $data;
    }

}
