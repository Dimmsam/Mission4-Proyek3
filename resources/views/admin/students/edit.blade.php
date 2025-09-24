@extends('layouts.admin')

@section('title', 'Edit Student')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Student</h1>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Student Information</h6>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.students.update', $student->student_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" name="user_id" value="{{ $student->user->id }}">
                        
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="{{ old('username', $student->user->username) }}" placeholder="Enter username" required>
                        </div>

                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="{{ old('full_name', $student->user->full_name) }}" placeholder="Enter full name" required>
                        </div>

                        <div class="form-group">
                            <label for="entry_year">Entry Year</label>
                            <input type="number" class="form-control" id="entry_year" name="entry_year" 
                                   value="{{ old('entry_year', $student->entry_year) }}" min="2000" max="{{ date('Y') + 1 }}" 
                                   placeholder="Enter entry year" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Student
                            </button>
                            <a href="{{ route('admin.students.detail', $student->student_id) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> View Detail
                            </a>
                            <a href="{{ route('admin.students') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection