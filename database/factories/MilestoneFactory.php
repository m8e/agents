<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\Milestone;
use App\Models\Objective;
use Illuminate\Database\Eloquent\Factories\Factory;

class MilestoneFactory extends Factory
{
    protected $model = Milestone::class;

    public function definition()
    {
        return [
            'objective_id' => Objective::factory(),
            'assigned_to' => Agent::factory(),
            'title' => $this->faker->sentence,
            'progress' => $this->faker->numberBetween(0, 100),
            'milestone_status' => $this->faker->randomElement(['not_started', 'in_progress', 'completed']),
            'milestone_priority' => $this->faker->randomElement(['critical', 'high', 'medium', 'low']),
        ];
    }
}
