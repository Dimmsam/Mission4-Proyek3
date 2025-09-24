<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'course_name' => 'Pemrograman Web',
            'credits' => 3
        ]);

        Course::create([
            'course_name' => 'Basis Data',
            'credits' => 3
        ]);

        Course::create([
            'course_name' => 'Algoritma dan Struktur Data',
            'credits' => 4
        ]);

        Course::create([
            'course_name' => 'Sistem Operasi',
            'credits' => 3
        ]);

        Course::create([
            'course_name' => 'Jaringan Komputer',
            'credits' => 3
        ]);
    }
}
