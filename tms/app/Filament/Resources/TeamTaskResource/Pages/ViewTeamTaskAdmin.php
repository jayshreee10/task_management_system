<?php
namespace App\Filament\Resources\TeamTaskResource\Pages;

use App\Filament\Resources\TeamTaskResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\Task;
class ViewTeamTaskAdmin extends ViewRecord
{
    protected static string $resource = TeamTaskResource::class;

    public $tasks;

    public function getTitle(): string
    {
        return "Team Task Details";
    }

    public function getView(): string
    {

        return 'filament.resources.team-task-resource.pages.view-team-task-admin';
    }



    public function mount(string|int $record): void
    {
        parent::mount($record);
        // \Log::info("Tasks for record {$record}");


        // $task = $this->getRecord();
        // \Log::info("team log {$team}");


    //   $data= Task::where('team_id', $record)->get();
    // $data = Task::query(where('team_id', $record)->get())
    //   \Log::info("data for record {$data}");

    //    $this->tasks = $data;



        // $this->tasks = $this->tasks ?? collect();

        // $this->tasks = Task::where('team_id', $task->team_id)->get();
        // \Log::info("Tasks for Team ID {$record}: ", $this->tasks->toArray());




        $data = Task::where('team_id', $record)->get();

        // \Log::info("data for record {$data}");

        $this->tasks = $data;
    }
}
