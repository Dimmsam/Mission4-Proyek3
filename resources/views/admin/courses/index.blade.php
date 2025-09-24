@extends('layouts.admin')

@section('title', 'Manage Courses')

@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Course Management</h1>
    <p class="mb-4">Manage all courses in the system. You can add, edit and delete course records.</p>

    <!-- Add Course Button -->
    <div class="mb-4">
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Course
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Courses Data</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Course Name</th>
                            <th>Credits</th>
                            <th>Enrolled Students</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                        <tr>
                            <td>{{ $course->course_id }}</td>
                            <td>{{ $course->course_name }}</td>
                            <td>{{ $course->credits }}</td>
                            <td>
                                <span class="badge badge-info">{{ $course->students_count }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.courses.edit', $course->course_id) }}" 
                                   class="btn btn-warning btn-circle btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.courses.delete', $course->course_id) }}" method="POST" 
                                      style="display: inline;"
                                      class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-circle btn-sm delete-btn" 
                                            title="Delete"
                                            data-type="course"
                                            data-name="{{ $course->course_name }}"
                                            data-credits="{{ $course->credits }}"
                                            data-students="{{ $course->students_count }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No courses found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
    
    <script>
    // Enhanced delete confirmation untuk courses dengan informasi SKS dan students
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const name = this.getAttribute('data-name');
                const credits = this.getAttribute('data-credits');
                const students = this.getAttribute('data-students');
                const form = this.closest('.delete-form');
                
                // Custom confirmation dengan informasi course
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.id = 'deleteCourseModal';
                modal.innerHTML = `
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">
                                    <i class="fas fa-exclamation-triangle"></i> Confirm Delete Course
                                </h5>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this course?</p>
                                <div class="alert alert-warning">
                                    <strong>Course:</strong> ${name}<br>
                                    <strong>Credits:</strong> ${credits} SKS<br>
                                    <strong>Enrolled Students:</strong> ${students}
                                </div>
                                <p class="text-muted">This action cannot be undone and will remove all student enrollments.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" id="confirmDeleteCourse">
                                    <i class="fas fa-trash"></i> Delete Course
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(modal);
                $('#deleteCourseModal').modal('show');
                
                document.getElementById('confirmDeleteCourse').addEventListener('click', function() {
                    $('#deleteCourseModal').modal('hide');
                    setTimeout(() => {
                        document.body.removeChild(modal);
                        form.submit();
                    }, 300);
                });
                
                $('#deleteCourseModal').on('hidden.bs.modal', function() {
                    if (modal.parentNode) {
                        document.body.removeChild(modal);
                    }
                });
            });
        });
    });
    </script>
@endpush