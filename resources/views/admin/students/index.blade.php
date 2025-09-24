@extends('layouts.admin')

@section('title', 'Manage Students')

@push('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Students Management</h1>
    <p class="mb-4">Manage all students in the system. You can add, edit, view details and delete student records.</p>

    <!-- Add Student Button -->
    <div class="mb-4">
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Add New Student
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Students Data</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Entry Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->user->username }}</td>
                            <td>{{ $student->user->full_name }}</td>
                            <td>{{ $student->entry_year }}</td>
                            <td>
                                <a href="{{ route('admin.students.detail', $student->student_id) }}" 
                                   class="btn btn-info btn-circle btn-sm" title="View Details">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="{{ route('admin.students.edit', $student->student_id) }}" 
                                   class="btn btn-warning btn-circle btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.students.delete', $student->student_id) }}" method="POST" 
                                      style="display: inline;" 
                                      class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-circle btn-sm delete-btn" 
                                            title="Delete"
                                            data-type="student"
                                            data-name="{{ $student->user->full_name }}"
                                            data-id="{{ $student->student_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No students found</td>
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
    // Custom delete confirmation untuk students
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const name = this.getAttribute('data-name');
                const form = this.closest('.delete-form');
                
                showDeleteConfirmation(type, name, function() {
                    form.submit();
                });
            });
        });
    });
    </script>
@endpush