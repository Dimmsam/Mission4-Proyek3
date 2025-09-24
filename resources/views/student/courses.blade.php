@extends('layouts.admin')

@section('title', 'Available Courses')

@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('title', 'Available Courses')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Available Courses</h1>
    </div>

    @if($availableCourses->count() > 0)
    <div class="row">
        <!-- Course Selection Form -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Select Courses to Enroll</h6>
                </div>
                <div class="card-body">
                    <form id="multiEnrollForm" action="{{ route('student.enroll') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="50px">Select</th>
                                        <th>Course ID</th>
                                        <th>Course Name</th>
                                        <th>Credits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($availableCourses as $course)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" 
                                                   name="course_ids[]" 
                                                   value="{{ $course->course_id }}"
                                                   data-credits="{{ $course->credits }}"
                                                   data-course-name="{{ $course->course_name }}"
                                                   class="form-check-input course-checkbox">
                                        </td>
                                        <td>{{ $course->course_id }}</td>
                                        <td>{{ $course->course_name }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $course->credits }} Credits</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" id="enrollBtn" class="btn btn-success">
                                <i class="fas fa-check"></i> Enroll Selected Courses
                            </button>
                            <a href="{{ route('student.my-courses') }}" class="btn btn-secondary">
                                <i class="fas fa-graduation-cap"></i> View My Courses
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Selection Summary -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Selection Summary</h6>
                </div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center mb-3">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Selected Courses
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span id="courseCount">0</span> Courses
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    
                    <div class="row no-gutters align-items-center mb-3">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total SKS
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span id="totalSKS" class="badge badge-secondary badge-lg">0</span> SKS
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
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
                    <i class="fas fa-book-open fa-5x text-gray-300 mb-4"></i>
                    <h3 class="text-gray-800">No Available Courses</h3>
                    <p class="text-muted mb-4">You have enrolled in all available courses or there are no courses available at the moment.</p>
                    <a href="{{ route('student.my-courses') }}" class="btn btn-primary">
                        <i class="fas fa-graduation-cap"></i> View My Courses
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