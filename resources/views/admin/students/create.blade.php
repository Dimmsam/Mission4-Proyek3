@extends('layouts.admin')

@section('title', 'Add Student')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add New Student</h1>

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

                    <form action="{{ route('admin.students.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="{{ old('username') }}" placeholder="Enter username" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="Enter password (min 6 characters)" required>
                        </div>

                        <div class="form-group">
                            <label for="full_name">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="{{ old('full_name') }}" placeholder="Enter full name" required>
                        </div>

                        <div class="form-group">
                            <label for="entry_year">Entry Year <span class="text-danger">*</span></label>
                            <select class="form-control" id="entry_year" name="entry_year" required>
                                <option value="">Select Entry Year</option>
                                @for($year = date('Y'); $year >= 2020; $year--)
                                    <option value="{{ $year }}" {{ old('entry_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Add Student
                            </button>
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