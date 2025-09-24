@extends('layouts.admin')

@section('title', 'Add Course')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add New Course</h1>

    <!-- Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Course Information</h6>
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

                    <form action="{{ route('admin.courses.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="course_name">Course Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="course_name" name="course_name" 
                                   value="{{ old('course_name') }}" placeholder="Enter course name" required>
                        </div>

                        <div class="form-group">
                            <label for="credits">Credits <span class="text-danger">*</span></label>
                            <select class="form-control" id="credits" name="credits" required>
                                <option value="">Select Credits</option>
                                <option value="1" {{ old('credits') == '1' ? 'selected' : '' }}>1 Credit</option>
                                <option value="2" {{ old('credits') == '2' ? 'selected' : '' }}>2 Credits</option>
                                <option value="3" {{ old('credits') == '3' ? 'selected' : '' }}>3 Credits</option>
                                <option value="4" {{ old('credits') == '4' ? 'selected' : '' }}>4 Credits</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Add Course
                            </button>
                            <a href="{{ route('admin.courses') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection