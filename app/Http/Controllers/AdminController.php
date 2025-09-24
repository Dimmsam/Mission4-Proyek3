<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Take;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalStudents = Student::count();
        $totalCourses = Course::count();
        
        return view('admin.dashboard', compact('totalStudents', 'totalCourses'));
    }

    // Manage Students
    public function students()
    {
        $students = Student::with('user')->get();
        return view('admin.students.index', compact('students'));
    }

    public function createStudent()
    {
        return view('admin.students.create');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'full_name' => 'required',
            'entry_year' => 'required|integer',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => $request->password,
            'role' => 'student',
            'full_name' => $request->full_name,
        ]);

        Student::create([
            'entry_year' => $request->entry_year,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.students')->with('success', 'Student berhasil ditambahkan');
    }

    public function detailStudent($id)
    {
        $student = Student::with(['user', 'courses'])->findOrFail($id);
        return view('admin.students.detail', compact('student'));
    }

    public function editStudent($id)
    {
        $student = Student::with('user')->findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function updateStudent(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $request->user_id,
            'full_name' => 'required',
            'entry_year' => 'required|integer',
        ]);

        $student = Student::with('user')->findOrFail($id);
        
        $student->user->update([
            'username' => $request->username,
            'full_name' => $request->full_name,
        ]);

        $student->update([
            'entry_year' => $request->entry_year,
        ]);

        return redirect()->route('admin.students')->with('success', 'Student berhasil diupdate');
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;
        
        // Hapus enrollment terlebih dahulu
        $student->takes()->delete();
        
        $student->delete();
        $user->delete();

        return redirect()->route('admin.students')->with('success', 'Student berhasil dihapus');
    }

    // Manage Courses
    public function courses()
    {
        $courses = Course::withCount('students')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function createCourse()
    {
        return view('admin.courses.create');
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'course_name' => 'required',
            'credits' => 'required|integer|min:1|max:4',
        ]);

        Course::create($request->all());

        return redirect()->route('admin.courses')->with('success', 'Course berhasil ditambahkan');
    }

    public function editCourse($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    public function updateCourse(Request $request, $id)
    {
        $request->validate([
            'course_name' => 'required',
            'credits' => 'required|integer|min:1|max:4',
        ]);

        $course = Course::findOrFail($id);
        $course->update($request->all());

        return redirect()->route('admin.courses')->with('success', 'Course berhasil diupdate');
    }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        
        // Hapus semua enrollment (data di tabel takes) terlebih dahulu
        $course->takes()->delete();
        
        // Sekarang baru hapus course
        $course->delete();

        return redirect()->route('admin.courses')->with('success', 'Course berhasil dihapus');
    }
}
