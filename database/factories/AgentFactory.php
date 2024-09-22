<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgentFactory extends Factory
{
    protected $model = Agent::class;

    public function definition()
    {
        return [
            'team_id' => Team::factory(),
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'type' => $this->faker->randomElement(['ai', 'human', 'bot']),
            'status' => $this->faker->randomElement(['active', 'inactive', 'suspended']),
            'config' => null,
            'capabilities' => null,
            'last_active_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
