<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'parent_id' => null,
            'related_object_type' => 'objectives',
            'related_object_id' => null, // Will be assigned in the seeder
            'comment_text' => $this->faker->paragraph,
        ];
    }
}
