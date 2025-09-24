@extends('layouts.admin')

@section('title', 'Student Dashboard')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Student Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Enrolled Courses Card -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Enrolled Courses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $enrolledCourses->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('student.my-courses') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-arrow-right"></i> View My Courses
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Credits Card -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Credits</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCredits }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('student.courses') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Enroll More Courses
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Courses -->
    @if($enrolledCourses->count() > 0)
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">My Recent Courses</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Course ID</th>
                                    <th>Course Name</th>
                                    <th>Credits</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enrolledCourses->take(5) as $course)
                                <tr>
                                    <td>{{ $course->course_id }}</td>
                                    <td>{{ $course->course_name }}</td>
                                    <td>{{ $course->credits }}</td>
                                    <td>
                                        <span class="badge badge-success">Enrolled</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($enrolledCourses->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('student.my-courses') }}" class="btn btn-primary">View All Courses</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-book fa-3x text-gray-300 mb-3"></i>
                    <h4>No Enrolled Courses</h4>
                    <p class="text-muted">You haven't enrolled in any courses yet.</p>
                    <a href="{{ route('student.courses') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Browse Available Courses
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection