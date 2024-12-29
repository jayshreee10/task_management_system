<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskDueDateReminderNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckTaskDueDates extends Command
{
    protected $signature = 'tasks:check-due-dates';
    protected $description = 'Check and notify users about tasks due soon or overdue';

    public function handle()
    {
        try {
            // Tasks due today or overdue
            $tasks = Task::where('status', '!=', 'complete')
                ->whereDate('due_date', '<=', Carbon::today()->addDays(2))
                ->get();

            foreach ($tasks as $task) {
                if ($task->assigned_to) {
                    $user = $task->assignedUser;

                    if ($user) {
                        $user->notify(
                            new TaskDueDateReminderNotification($task)
                        );
                    }
                }
            }

            $this->info('Task due date check completed successfully.');
            return 0;
        } catch (\Exception $e) {
            Log::error('Task due date check failed: ' . $e->getMessage());
            $this->error('An error occurred: ' . $e->getMessage());
            return 1;
        }
    }
}
