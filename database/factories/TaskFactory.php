<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\Goal;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'goal_id' => Goal::factory(),
            'assigned_to' => Agent::factory(),
            'title' => $this->faker->sentence,
            'progress' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['not_started', 'in_progress', 'completed']),
            'priority' => $this->faker->randomElement(['critical', 'high', 'medium', 'low']),
        ];
    }
}
