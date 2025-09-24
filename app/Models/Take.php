<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Take extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'enroll_date'
    ];

    protected $casts = [
        'enroll_date' => 'datetime'
    ];

    // Relasi dengan Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    // Relasi dengan Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }
}
