<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
            ],
            [
                'name' => 'DevOps & Cloud',
                'slug' => 'devops-cloud',
            ],
            [
                'name' => 'Artificial Intelligence',
                'slug' => 'artificial-intelligence',
            ],
            [
                'name' => 'Programming Languages',
                'slug' => 'programming-languages',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}