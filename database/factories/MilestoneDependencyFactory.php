<?php

namespace Database\Factories;

use App\Models\Milestone;
use App\Models\MilestoneDependency;
use Illuminate\Database\Eloquent\Factories\Factory;

class MilestoneDependencyFactory extends Factory
{
    protected $model = MilestoneDependency::class;

    public function definition()
    {
        return [
            'milestone_id' => Milestone::factory(),
            'depends_on_milestone_id' => Milestone::factory(),
        ];
    }
}
