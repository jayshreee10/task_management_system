<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;

class TeamUserSeeder extends Seeder
{

    public function run()
    {

        $teams = Team::factory()->count(5)->create();


        $users = User::factory()->count(10)->create();


        $teams->each(function ($team) use ($users) {
            $team->users()->attach(
                $users->random(rand(2, 5))->pluck('id')->toArray()
            );
        });
    }
}
