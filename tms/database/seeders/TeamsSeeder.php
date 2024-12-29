<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TeamsSeeder extends Seeder
{
    public function run()
    {
        // Example data for teams
        $teams = [
            [
                'name' => 'Development Team',
                'description' => 'Handles all software development tasks.',
                'members' => json_encode([15, 16, 19]), // IDs of users as members
                'leads' => json_encode([1, 17]),       // IDs of users as leads
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Marketing Team',
                'description' => 'Responsible for marketing, outreach, and branding.',
                'members' => json_encode([16, 20]),    // IDs of users as members
                'leads' => json_encode([15]),         // IDs of users as leads
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Operations Team',
                'description' => 'Manages day-to-day operations and logistics.',
                'members' => json_encode([19, 20]),   // IDs of users as members
                'leads' => json_encode([17]),         // IDs of users as leads
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'HR Team',
                'description' => 'Handles recruitment, employee engagement, and HR policies.',
                'members' => json_encode([15, 19]),  // IDs of users as members
                'leads' => json_encode([1]),         // IDs of users as leads
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Finance Team',
                'description' => 'Manages company finances and budgeting.',
                'members' => json_encode([16]),      // IDs of users as members
                'leads' => json_encode([20]),        // IDs of users as leads
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Product Team',
                'description' => 'Oversees product development and strategy.',
                'members' => json_encode([15, 17, 19]), // IDs of users as members
                'leads' => json_encode([16]),        // IDs of users as leads
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Insert the data into the teams table
        DB::table('teams')->insert($teams);
    }
}
