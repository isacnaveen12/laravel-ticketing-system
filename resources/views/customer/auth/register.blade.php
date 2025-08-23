@extends('customer.layouts.auth')

@section('title', 'Customer Registration')
@section('subtitle', 'Create your account')

@section('content')
<form method="POST" action="{{ route('customer.register') }}">
    @csrf
    
    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                   name="name" value="{{ old('name') }}" required autofocus>
        </div>
        @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                   name="email" value="{{ old('email') }}" required>
        </div>
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                   name="password" required>
        </div>
        @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input id="password_confirmation" type="password" class="form-control" 
                   name="password_confirmation" required>
        </div>
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="terms" required>
            <label class="form-check-label" for="terms">
                I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> 
                and <a href="#" class="text-decoration-none">Privacy Policy</a>
            </label>
        </div>
    </div>

    <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-person-plus"></i> Create Account
        </button>
    </div>

    <div class="text-center">
        <p class="mb-0">
            Already have an account? 
            <a href="{{ route('customer.login') }}" class="text-decoration-none fw-bold">Sign in here</a>
        </p>
    </div>
</form>
@endsection

@section('footer-text')
    <a href="{{ url('/') }}" class="text-white-50 text-decoration-none">
        <i class="bi bi-arrow-left"></i> Back to home
    </a>
@endsection