@extends('layouts.admin')

@section('title', 'My Courses')

@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Enrolled Courses</h1>
        @if($enrolledCourses->count() > 0)
            <div class="d-sm-flex">
                <span class="badge badge-success p-2">
                    <i class="fas fa-graduation-cap"></i> Total Credits: {{ $enrolledCourses->sum('credits') }}
                </span>
            </div>
        @endif
    </div>

    @if($enrolledCourses->count() > 0)
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Enrolled Courses</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                        @foreach($enrolledCourses as $course)
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
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <div class="small text-muted">
                        Total Enrolled Courses: {{ $enrolledCourses->count() }}
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <div class="small">
                        <span class="font-weight-bold text-success">Total Credits: {{ $enrolledCourses->sum('credits') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body text-center py-5">
                    <i class="fas fa-graduation-cap fa-5x text-gray-300 mb-4"></i>
                    <h3 class="text-gray-800">No Courses Enrolled</h3>
                    <p class="text-muted mb-4">You haven't enrolled in any courses yet. Browse available courses to get started with your learning journey.</p>
                    <a href="{{ route('student.courses') }}" class="btn btn-primary">
                        <i class="fas fa-book-open"></i> Browse Available Courses
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush