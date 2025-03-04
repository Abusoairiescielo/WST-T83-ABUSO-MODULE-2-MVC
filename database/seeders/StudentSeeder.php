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
            'password' => 'password', // Plain password for admin
            'user_type' => 'instructor',
        ]);

        for ($i = 1; $i <= 50; $i++) {
            try {
                $firstName = fake()->firstName;
                $lastName = fake()->lastName;
                $name = $firstName . ' ' . $lastName;
                
                // Generate student ID with proper format (2024 + 6 digits)
                $studentId = '2024' . str_pad($i, 6, '0', STR_PAD_LEFT);
                
                // Create clean email (firstname.lastname@student.buksu.edu.ph)
                $emailPrefix = Str::lower(Str::slug($firstName . '.' . $lastName, '.'));
                $email = $emailPrefix . '@student.buksu.edu.ph';
                
                // Create student record
                Students::create([
                    'student_id' => $studentId,
                    'name' => $name,
                    'email' => $email,
                    'status' => 'active',
                    'enrollment_status' => 'pending'
                ]);

                // Create corresponding user account with plain student ID as password
                User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $studentId, // Plain student ID as password
                    'user_type' => 'student'
                ]);
            } catch (\Exception $e) {
                // Log error and continue with next iteration
                \Log::error("Error seeding student {$i}: " . $e->getMessage());
                continue;
            }
        }
    }
}
