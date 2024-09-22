<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\Goal;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
{
    protected $model = Goal::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $deadlineDate = $this->faker->dateTimeBetween($startDate, '+3 months');

        return [
            'team_id' => Team::factory(),
            'user_id' => User::factory(),
            'agent_id' => Agent::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'icon' => $this->faker->imageUrl(),
            'start_date' => $startDate,
            'deadline_date' => $deadlineDate,
            'progress' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['not_started', 'in_progress', 'completed']),
            'priority' => $this->faker->randomElement(['critical', 'high', 'normal', 'low', 'backlog']),
            'risk_level' => $this->faker->randomElement(['low', 'medium', 'high']),
            'estimated_tokens' => $this->faker->numberBetween(100, 1000),
            'actual_tokens' => $this->faker->numberBetween(100, 1000),
            'outcome' => $this->faker->paragraph,
            'tags' => implode(',', $this->faker->words(3)),
            'completion_criteria' => $this->faker->sentence,
        ];
    }
}
