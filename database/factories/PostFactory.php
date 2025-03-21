<?php

namespace Database\Factories;

use App\Enums\PostStatus;
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
            'excerpt' => fake()->words(rand(10, 15), true),
            'content' => fake()->paragraph(rand(5, 15)),
            'status' => fake()->randomElement(PostStatus::cases()),
            'is_featured' => false,
        ];
    }
}
