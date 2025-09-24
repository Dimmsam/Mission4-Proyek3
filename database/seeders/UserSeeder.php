<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin
        User::create([
            'username' => 'admin',
            'password' => 'admin123',
            'role' => 'admin',
            'full_name' => 'Administrator'
        ]);

        // Buat beberapa user student
        $student1 = User::create([
            'username' => 'john_doe',
            'password' => 'student123',
            'role' => 'student',
            'full_name' => 'John Doe'
        ]);

        $student2 = User::create([
            'username' => 'jane_smith',
            'password' => 'student123',
            'role' => 'student',
            'full_name' => 'Jane Smith'
        ]);

        // Buat data student corresponding
        Student::create([
            'entry_year' => 2023,
            'user_id' => $student1->id
        ]);

        Student::create([
            'entry_year' => 2024,
            'user_id' => $student2->id
        ]);
    }
}
