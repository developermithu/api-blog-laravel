<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate 5 categories with random number of posts
        Category::factory()
            ->count(5)
            ->has(
                Post::factory()
                    ->count(rand(5, 10))
            )
            ->create();

        // Mark the latest post as featured
        $latestPost = Post::latest()->first();

        if ($latestPost) {
            $latestPost->update(['is_featured' => true]);
        }
    }
}
