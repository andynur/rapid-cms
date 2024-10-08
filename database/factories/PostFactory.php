<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $total_user = User::count();
        return [
            'title' => fake()->sentence,
            'slug' => Str::slug(fake()->sentence),
            'user_id' => random_int(1, $total_user),
            'main_image' => fake()->imageUrl(),
            'body' => fake()->paragraphs(3, true),
            'categories' => fake()->randomElement(['tech', 'lifestyle', 'web3', 'ai']),
            'published_at' => now(),
        ];
    }
}
