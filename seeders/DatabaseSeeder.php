<?php

namespace Database\Seeders;

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
            'name' => 'Sara Nelson',
            'email' => 'saranelson@saranelson.com',
            'password' => bcrypt('password123'), 
        ]);

        User::factory()->create([
            'name' => 'Eesha',
            'email' => 'eesha@eesha.com',
            'password' => bcrypt('password123'),
        ]);

        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => bcrypt('password123'),
        ]);
    }
}
