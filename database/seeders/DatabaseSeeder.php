<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Agent;
use App\Models\Comment;
use App\Models\Goal;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables to start fresh
        User::truncate();
        Team::truncate();
        Agent::truncate();
        Goal::truncate();
        Task::truncate();
        Comment::truncate();
        ActivityLog::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create a primary user with a personal team
        $owner = User::factory()->withPersonalTeam()->create([
            'email' => 'owner@example.com',
            'name'  => 'Owner User',
        ]);

        // Create additional users (optional)
        $users = User::factory()->count(25)->create();

        // Get the owner's personal team
        $team = $owner->personalTeam();

        // Assign users to the team (optional)
        foreach ($users as $user) {
            $team->users()->attach($user, ['role' => 'editor']);
        }

        // Create agents associated with the team
        $agents = Agent::factory()->count(3)->create([
            'team_id' => $team->id,
        ]);

        // Create at least 30 goals
        $goals = [];

        for ($i = 0; $i < 30; $i++) {
            $goal = Goal::create([
                'team_id'     => $team->id,
                'user_id'     => $owner->id,
                'agent_id'    => $agents->random()->id,
                'title'       => 'Goal ' . ($i + 1),
                'description' => 'Description for Goal ' . ($i + 1),
                'start_date'  => now(),
                'status'      => 'not_started',
                'priority'    => 'normal',
                'risk_level'  => 'medium',
            ]);

            $goals[] = $goal;
        }

        foreach ($goals as $goal) {
            // Decide how many tasks to create for this goal
            $numTasks = rand(5, 30);

            // Initialize an array to keep track of tasks
            $tasks = [];

            // Create the initial task queue
            $taskQueue = [];

            // Create the root tasks (tasks with no parent)
            $numRootTasks = rand(1, min(5, $numTasks)); // At least 1 root task

            for ($i = 0; $i < $numRootTasks; $i++) {
                $task = Task::create([
                    'goal_id'        => $goal->id,
                    'assigned_to'    => $agents->random()->id,
                    'title'          => 'Task ' . ($i + 1) . ' for Goal ' . $goal->id,
                    'status'         => 'not_started',
                    'priority'       => 'medium',
                    'parent_task_id' => null,
                ]);

                $tasks[]     = $task;
                $taskQueue[] = $task; // Add to queue to create subtasks
            }

            $remainingTasks = $numTasks - $numRootTasks;

            // Now create child tasks under the tasks in the queue
            while ($remainingTasks > 0 && !empty($taskQueue)) {
                // Pop a task from the queue
                $parentTask = array_shift($taskQueue);

                // Decide how many child tasks to create under this parent
                $numChildTasks = rand(1, min(5, $remainingTasks)); // Limit to 5 child tasks or remaining tasks

                for ($i = 0; $i < $numChildTasks; $i++) {
                    $task = Task::create([
                        'goal_id'        => $goal->id,
                        'assigned_to'    => $agents->random()->id,
                        'title'          => 'Subtask ' . ($i + 1) . ' under Task ' . $parentTask->id . ' for Goal ' . $goal->id,
                        'status'         => 'not_started',
                        'priority'       => 'medium',
                        'parent_task_id' => $parentTask->id,
                    ]);

                    $tasks[]     = $task;
                    $taskQueue[] = $task; // Add the new task to the queue for further subtasks
                    $remainingTasks--;

                    if ($remainingTasks <= 0) {
                        break;
                    }
                }
            }

            // Optionally, create comments and activity logs for each goal
            // Create a comment for the goal
            Comment::create([
                'user_id'            => $users->random()->id,
                'related_object_type' => Goal::class,
                'related_object_id'   => $goal->id,
                'comment_text'        => 'This goal is critical for our next quarter objectives.',
            ]);

            // Create an activity log for the goal
            ActivityLog::create([
                'team_id'            => $team->id,
                'user_id'            => $users->random()->id,
                'agent_id'           => $agents->random()->id,
                'activity_type'      => 'created',
                'related_object_type' => Goal::class,
                'related_object_id'   => $goal->id,
                'details'            => 'Goal created and tasks assigned.',
            ]);
        }
    }
}
