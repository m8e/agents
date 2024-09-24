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
use Laravel\Jetstream\Jetstream;

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
            'name' => 'Owner User',
        ]);

        // Create additional users
        $users = User::factory()->count(25)->create();

        // Create teams and assign users
        $teams = Team::factory()->count(5)->create();

        $teams->push($owner->personalTeam());

        $teams->each(function ($team, $index) use ($users, $owner): void {
            // Assign 5 users to each team
            $teamUsers = $users;

            foreach ($teamUsers as $user) {
                // Add users to the team
                $team->users()->attach($user, ['role' => 'editor']);
            }

            // Set the owner as the team owner
            $team->update(['user_id' => $owner->id]);

            // Create agents associated with the team
            $agents = Agent::factory()->count(3)->create([
                'team_id' => $team->id,
            ]);

            // Define realistic goals for an agentic system
            $goalsData = [
                [
                    'title' => 'Develop AI-Powered Chatbot',
                    'description' => 'Create a chatbot to handle customer inquiries using AI.',
                ],
                [
                    'title' => 'Implement Automated Email Sorting',
                    'description' => 'Design an agent to categorize incoming emails automatically.',
                ],
                [
                    'title' => 'Create Predictive Maintenance System',
                    'description' => 'Develop an AI agent to predict equipment failures before they occur.',
                ],
                [
                    'title' => 'Enhance Fraud Detection Mechanisms',
                    'description' => 'Build an agent to identify and prevent fraudulent activities.',
                ],
                [
                    'title' => 'Optimize Content Recommendation Engine',
                    'description' => 'Improve the recommendation system using advanced AI algorithms.',
                ],
            ];

            foreach ($goalsData as $goalData) {
                $goal = Goal::create([
                    'team_id' => $team->id,
                    'user_id' => $teamUsers->random()->id,
                    'agent_id' => $agents->random()->id,
                    'title' => $goalData['title'],
                    'description' => $goalData['description'],
                    'start_date' => now(),
                    'status' => 'not_started',
                    'priority' => 'normal',
                    'risk_level' => 'medium',
                ]);

                // Define realistic tasks for each goal
                $tasksData = [];

                switch ($goalData['title']) {
                    case 'Develop AI-Powered Chatbot':
                        $tasksData = [
                            'Gather Frequently Asked Questions',
                            'Design Conversation Flow',
                            'Develop Natural Language Processing Module',
                            'Integrate Chatbot with Website',
                            'Conduct User Acceptance Testing',
                        ];
                        break;

                    case 'Implement Automated Email Sorting':
                        $tasksData = [
                            'Analyze Email Categories',
                            'Develop Classification Algorithms',
                            'Integrate with Email Server',
                            'Test Sorting Accuracy',
                            'Deploy to All Users',
                        ];
                        break;

                    case 'Create Predictive Maintenance System':
                        $tasksData = [
                            'Collect Equipment Data Logs',
                            'Identify Failure Patterns',
                            'Develop Predictive Models',
                            'Integrate with Monitoring Systems',
                            'Train Maintenance Staff',
                        ];
                        break;

                    case 'Enhance Fraud Detection Mechanisms':
                        $tasksData = [
                            'Review Current Security Measures',
                            'Identify Common Fraud Indicators',
                            'Develop Real-Time Monitoring Agent',
                            'Implement Machine Learning Models',
                            'Set Up Alert System',
                        ];
                        break;

                    case 'Optimize Content Recommendation Engine':
                        $tasksData = [
                            'Analyze User Interaction Data',
                            'Improve Recommendation Algorithms',
                            'Implement A/B Testing',
                            'Gather User Feedback',
                            'Deploy Updates to Production',
                        ];
                        break;
                }

                foreach ($tasksData as $taskTitle) {
                    Task::create([
                        'goal_id' => $goal->id,
                        'assigned_to' => $agents->random()->id,
                        'title' => $taskTitle,
                        'status' => 'not_started',
                        'priority' => 'medium',
                    ]);
                }

                // Create a comment for each goal
                Comment::create([
                    'user_id' => $teamUsers->random()->id,
                    'related_object_type' => Goal::class,
                    'related_object_id' => $goal->id,
                    'comment_text' => 'This goal is critical for our next quarter objectives.',
                ]);

                // Create an activity log for each goal
                ActivityLog::create([
                    'team_id' => $team->id,
                    'user_id' => $teamUsers->random()->id,
                    'agent_id' => $agents->random()->id,
                    'activity_type' => 'created', // Updated field name
                    'related_object_type' => Goal::class,
                    'related_object_id' => $goal->id,
                    'details' => 'Goal created and tasks assigned.', // Updated field name
                ]);
            }
        });
    }
}
