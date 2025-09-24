<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Take;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $student = $user->student;
        $enrolledCourses = $student->courses;
        $totalCredits = $enrolledCourses->sum('credits');
        
        return view('student.dashboard', compact('enrolledCourses', 'totalCredits'));
    }

    public function courses()
    {
        $user = Auth::user();
        $student = $user->student;
        $enrolledCourseIds = $student->courses->pluck('course_id');
        $availableCourses = Course::whereNotIn('course_id', $enrolledCourseIds)->get();
        
        return view('student.courses', compact('availableCourses'));
    }

    public function enrollCourse(Request $request)
    {
        // Debug logging
        Log::info('Enroll course request received', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);
        
        $user = Auth::user();
        $student = $user->student;
        
        // Validate request
        if (!$request->has('course_ids') && !$request->has('course_id')) {
            return back()->with('error', 'No courses selected');
        }
        
        // Handle multiple course enrollment (Mission 4 requirement)
        if ($request->has('course_ids')) {
            $courseIds = $request->course_ids;
            $enrolled = [];
            $skipped = [];
            
            foreach ($courseIds as $courseId) {
                // Check if already enrolled
                $alreadyEnrolled = Take::where('student_id', $student->student_id)
                                      ->where('course_id', $courseId)
                                      ->exists();

                if (!$alreadyEnrolled) {
                    Take::create([
                        'student_id' => $student->student_id,
                        'course_id' => $courseId,
                        'enroll_date' => now(),
                    ]);
                    $enrolled[] = $courseId;
                } else {
                    $skipped[] = $courseId;
                }
            }
            
            $message = '';
            if (count($enrolled) > 0) {
                $message .= 'Berhasil mendaftar ' . count($enrolled) . ' course(s). ';
            }
            if (count($skipped) > 0) {
                $message .= count($skipped) . ' course(s) dilewati (sudah terdaftar).';
            }
            
            return back()->with('success', $message);
        }
        
        // No courses selected
        return back()->with('error', 'Please select at least one course to enroll');
    }

    public function myCourses()
    {
        $user = Auth::user();
        $student = $user->student;
        $enrolledCourses = $student->courses()->withPivot('enroll_date')->get();
        
        return view('student.my-courses', compact('enrolledCourses'));
    }
}
