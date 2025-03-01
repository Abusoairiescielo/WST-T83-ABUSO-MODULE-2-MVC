<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student\Students;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@buksu.edu.ph',
            'password' => Hash::make('password'),
            'user_type' => 'instructor',
        ]);

        $courses = ['BSIT', 'BSCS', 'BSIS'];
        $years = ['1st', '2nd', '3rd', '4th'];

        for ($i = 1; $i <= 50; $i++) {
            try {
                $firstName = fake()->firstName;
                $lastName = fake()->lastName;
                $name = $firstName . ' ' . $lastName;
                
                // Generate student ID with proper format
                $studentId = '2024' . str_pad($i, 6, '0', STR_PAD_LEFT);
                
                // Create clean email
                $emailPrefix = Str::slug($firstName . '.' . $lastName, '.');
                $email = $emailPrefix . '@student.buksu.edu.ph';
                
                // Create student record
                Students::create([
                    'student_id' => $studentId,
                    'name' => $name,
                    'email' => $email,
                    'course' => $courses[array_rand($courses)],
                    'year' => $years[array_rand($years)],
                    'status' => 'active'
                ]);

                // Create corresponding user account
                User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'user_type' => 'student'
                ]);

            } catch (\Exception $e) {
                \Log::error("Error seeding student $name: " . $e->getMessage());
                continue;
            }
        }
    }
}
