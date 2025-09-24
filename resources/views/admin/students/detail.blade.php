@extends('layouts.admin')

@section('title', 'Student Detail')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Student Detail</h1>
        <div>
            <a href="{{ route('admin.students.edit', $student->student_id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Student
            </a>
            <a href="{{ route('admin.students') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Students
            </a>
        </div>
    </div>

    <!-- Student Information Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Student Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Student ID:</td>
                                    <td>{{ $student->student_id }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Username:</td>
                                    <td>{{ $student->user->username }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Full Name:</td>
                                    <td>{{ $student->user->full_name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold">Entry Year:</td>
                                    <td>{{ $student->entry_year }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Role:</td>
                                    <td>
                                        <span class="badge badge-primary">{{ ucfirst($student->user->role) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Total Credits:</td>
                                    <td>
                                        <span class="badge badge-success">{{ $student->courses->sum('credits') }} Credits</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Stats</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-graduation-cap fa-3x text-gray-300 mb-2"></i>
                        <h4 class="text-gray-800">{{ $student->courses->count() }}</h4>
                        <p class="text-muted">Enrolled Courses</p>
                    </div>
                    <div>
                        <i class="fas fa-book fa-2x text-gray-300 mb-2"></i>
                        <h5 class="text-gray-800">{{ $student->courses->sum('credits') }}</h5>
                        <p class="text-muted">Total Credits</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($student->courses->count() > 0)
    <!-- Enrolled Courses -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Enrolled Courses ({{ $student->courses->count() }})</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Name</th>
                            <th>Credits</th>
                            <th>Enrollment Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->courses as $course)
                        <tr>
                            <td>{{ $course->course_id }}</td>
                            <td>{{ $course->course_name }}</td>
                            <td>
                                <span class="badge badge-info">{{ $course->credits }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($course->pivot->enroll_date)->format('d M Y, H:i') }}</td>
                            <td>
                                <span class="badge badge-success">
                                    <i class="fas fa-check"></i> Enrolled
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="card shadow mb-4">
        <div class="card-body text-center py-5">
            <i class="fas fa-book-open fa-5x text-gray-300 mb-4"></i>
            <h4 class="text-gray-800">No Enrolled Courses</h4>
            <p class="text-muted">This student hasn't enrolled in any courses yet.</p>
        </div>
    </div>
    @endif
@endsection