<?php

namespace Database\Seeders;

use App\Enums\Role;
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
        // User::factory(10)->create();

        User::factory()->create([
            'email' => 'admin@gmail.com',
            'role' => Role::Admin
        ]);
        
        User::factory()->create([
            'role' => Role::Teacher,
            'email' => 'teacher@gmail.com'
        ]);

        User::factory()->create([
            'role' => Role::Student,
            'email' => 'student@gmail.com'
        ]);

    }
}
