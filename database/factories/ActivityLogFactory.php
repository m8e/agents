<?php

namespace Database\Factories;

use App\Models\ActivityLog;
use App\Models\Agent;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityLogFactory extends Factory
{
    protected $model = ActivityLog::class;

    public function definition()
    {
        return [
            'team_id' => Team::factory(),
            'user_id' => User::factory(),
            'agent_id' => Agent::factory(),
            'activity_type' => $this->faker->randomElement(['created', 'updated', 'deleted', 'assigned', 'status_changed']),
            'related_object_type' => 'objectives',
            'related_object_id' => null, // Will be assigned in the seeder
            'details' => $this->faker->sentence,
        ];
    }
}
