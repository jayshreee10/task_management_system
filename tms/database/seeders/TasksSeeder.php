<?php
namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        // Retrieve all users for task assignment
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('No users found. Ensure the users table is populated.');
            return;
        }

        // Generate reusable comments for tasks
        $commentsList = [
            json_encode([
                [
                    'user_id' => 1,
                    'username' => 'Admin User',
                    'comment' => 'Task is in progress.',
                    'timestamp' => $now->subDays(1)->toDateTimeString(),
                ],
            ]),
            json_encode([
                [
                    'user_id' => 2,
                    'username' => 'Manager User',
                    'comment' => 'Reviewed the task, pending minor updates.',
                    'timestamp' => $now->subDays(2)->toDateTimeString(),
                ],
            ]),
            json_encode([
                [
                    'user_id' => 3,
                    'username' => 'Regular User',
                    'comment' => 'Awaiting review from the team lead.',
                    'timestamp' => $now->subDays(3)->toDateTimeString(),
                ],
            ]),
            json_encode([
                [
                    'user_id' => 4,
                    'username' => 'Margret Welch',
                    'comment' => 'Attachments added for reference.',
                    'timestamp' => $now->subDays(4)->toDateTimeString(),
                ],
            ]),
            json_encode([
                [
                    'user_id' => 5,
                    'username' => 'Randi Ryan',
                    'comment' => 'Task marked as complete.',
                    'timestamp' => $now->subDays(5)->toDateTimeString(),
                ],
            ]),
        ];

        // Create 5-10 tasks
        for ($i = 1; $i <= 10; $i++) {
            // Select a random user for assignment
            $assignedUser = $users->random();

            // Generate task data
            $taskData = [
                'title' => 'Task ' . $i,
                'description' => 'Description for task ' . $i,
                'comments' => $commentsList[array_rand($commentsList)],
                'attachments' => json_encode(['attachment_' . $i . '.pdf']),
                'status' => 'pending',
                'due_date' => $now->addDays(rand(1, 10)),
                'created_by' => 1, // Example user ID (Admin)
                'priority' => 'High',
                'assigned_to' => $assignedUser->id, // Assigned to random user
                'team_id' => null,
                'name' => 'Task ' . $i . ' Name',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Insert the task into the database
            Task::create($taskData);
        }

        $this->command->info('Tasks created successfully!');
    }
}
