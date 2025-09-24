<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Students management
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
    Route::get('/students/{id}/detail', [AdminController::class, 'detailStudent'])->name('students.detail');
    Route::get('/students/{id}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
    Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{id}', [AdminController::class, 'deleteStudent'])->name('students.delete');
    
    // Courses management 
    Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
    Route::get('/courses/create', [AdminController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
    Route::get('/courses/{id}/edit', [AdminController::class, 'editCourse'])->name('courses.edit');
    Route::put('/courses/{id}', [AdminController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/{id}', [AdminController::class, 'deleteCourse'])->name('courses.delete');
});

// Student routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
    Route::post('/enroll', [StudentController::class, 'enrollCourse'])->name('enroll');
    Route::get('/my-courses', [StudentController::class, 'myCourses'])->name('my-courses');
});
