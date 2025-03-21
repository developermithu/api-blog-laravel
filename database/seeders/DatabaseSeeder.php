<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Developer Mithu',
            'email' => 'developermithu@gmail.com',
            'password' => bcrypt('developermithu'),
            'email_verified_at' => now(),
            'role' => UserRole::ADMIN,
        ]);

        User::factory(10)->create();

        $this->call([
            PostSeeder::class,
        ]);
    }
}
