<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Agent;
use App\Models\Comment;
use App\Models\Milestone;
use App\Models\Objective;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Laravel\Jetstream\Jetstream;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Users
        $users = User::factory()->count(25)->create();

        // Create Teams and Assign Users
        $teams = Team::factory()->count(5)->create()->each(function ($team, $index) use ($users) {
            // Assign 5 users to each team
            $teamUsers = $users->slice($index * 5, 5);

            foreach ($teamUsers as $user) {
                // Use Jetstream's method to add users to teams
                $team->users()->attach($user, ['role' => 'editor']);
            }

            // Optionally, set the first user as the team owner
            $team->update(['user_id' => $teamUsers->first()->id]);

            // Create Agents associated with the team
            $agents = Agent::factory()->count(3)->create([
                'team_id' => $team->id,
            ]);

            // Create Objectives
            $objectives = Objective::factory()->count(10)->create([
                'team_id' => $team->id,
                'user_id' => $teamUsers->random()->id,
                'agent_id' => $agents->random()->id,
            ]);

            foreach ($objectives as $objective) {
                // Create Milestones for each Objective
                $milestones = Milestone::factory()->count(5)->create([
                    'objective_id' => $objective->id,
                    'assigned_to' => $agents->random()->id,
                ]);

                // Create Milestone Dependencies
                foreach ($milestones as $milestone) {
                    // Each milestone may depend on a previous milestone
                    $possibleDependencies = $milestones->where('id', '<', $milestone->id);
                    if ($possibleDependencies->isNotEmpty()) {
                        $dependencyId = $possibleDependencies->random()->id;
                        $milestone->dependencies()->attach($dependencyId);
                    }
                }

                // Create Comments for each Objective
                Comment::factory()->count(3)->create([
                    'user_id' => $teamUsers->random()->id,
                    'related_object_type' => Objective::class,
                    'related_object_id' => $objective->id,
                ]);

                // Create Activity Logs for each Objective
                ActivityLog::factory()->count(2)->create([
                    'team_id' => $team->id,
                    'user_id' => $teamUsers->random()->id,
                    'agent_id' => $agents->random()->id,
                    'related_object_type' => Objective::class,
                    'related_object_id' => $objective->id,
                ]);
            }
        });
    }
}
