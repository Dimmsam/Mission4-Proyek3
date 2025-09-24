<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $primaryKey = 'course_id';
    
    protected $fillable = [
        'course_name',
        'credits'
    ];

    // Relasi many-to-many dengan Student melalui tabel takes
    public function students()
    {
        return $this->belongsToMany(Student::class, 'takes', 'course_id', 'student_id')
                    ->withPivot('enroll_date')
                    ->withTimestamps();
    }

    // Relasi dengan Take
    public function takes()
    {
        return $this->hasMany(Take::class, 'course_id', 'course_id');
    }
}
