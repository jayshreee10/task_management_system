<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\TeamTask;
use Carbon\Carbon;

class TeamTaskSeeder extends Seeder
{
    public function run(): void
    {
        // Get all teams
        $teams = Team::all();

        // If no teams are found, output a message and return
        if ($teams->isEmpty()) {
            $this->command->info('No teams found. Please ensure teams are seeded before tasks.');
            return;
        }

        // Create tasks for each team
        foreach ($teams as $team) {
            // You can replace 'name' with the correct attribute if it differs
            $teamName = $team->name;

            // Creating 3 tasks for each team
            TeamTask::create([
                'team_id' => $team->id,
                'name' => 'Task for ' . $teamName,
                'description' => 'Description for task in team ' . $teamName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            TeamTask::create([
                'team_id' => $team->id,
                'name' => 'Task 2 for ' . $teamName,
                'description' => 'Another task for ' . $teamName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            TeamTask::create([
                'team_id' => $team->id,
                'name' => 'Urgent task for ' . $teamName,
                'description' => 'Urgent task assigned to ' . $teamName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
