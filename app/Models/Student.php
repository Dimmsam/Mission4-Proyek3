<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'student_id';
    
    protected $fillable = [
        'entry_year',
        'user_id'
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi many-to-many dengan Course melalui tabel takes
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'takes', 'student_id', 'course_id')
                    ->withPivot('enroll_date')
                    ->withTimestamps()
                    ->withCasts(['enroll_date' => 'datetime']);
    }

    // Relasi dengan Take
    public function takes()
    {
        return $this->hasMany(Take::class, 'student_id', 'student_id');
    }
}
