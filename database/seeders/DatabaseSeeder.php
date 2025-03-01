<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Remove the test user creation
        $this->call([
            StudentSeeder::class,
        ]);
    }
}
