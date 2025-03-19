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
        $title = fake()->sentence(rand(1, 5), true);
        $slug = Str::slug($title);

        return [
            'author_id' => 1,
            'title' => $title,
            'slug' => $slug,
            'content' => fake()->paragraph(rand(5, 15)),
        ];
    }
}
