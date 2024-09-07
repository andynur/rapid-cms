<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $total_post = Post::count();
        return [
            'post_id' => random_int(1, $total_post),
            'name' => fake()->name(),
            'email' => fake()->email(),
            'comment' => fake()->sentence(),
        ];
    }
}
