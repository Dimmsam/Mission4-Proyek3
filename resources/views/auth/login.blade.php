@extends('layouts.auth')

@section('title', 'Login - Course Management System')

@section('content')
    <div class="card o-hidden border-0 shadow-lg">
        <div class="card-body">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Login</h1>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form class="user" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control form-control-user"
                        id="username" name="username" value="{{ old('username') }}"
                        placeholder="Enter Username..." required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control form-control-user"
                        id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Login
                </button>
            </form>
            <hr>
            <div class="text-center">
                <small class="text-muted">Course Management System</small>
            </div>
        </div>
    </div>
@endsection