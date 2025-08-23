@extends('customer.layouts.auth')

@section('title', 'Customer Login')
@section('subtitle', 'Sign in to your account')

@section('content')
<form method="POST" action="{{ route('customer.login') }}">
    @csrf
    
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                   name="email" value="{{ old('email') }}" required autofocus>
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
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">
                Remember me
            </label>
        </div>
    </div>

    <div class="d-grid gap-2 mb-3">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-box-arrow-in-right"></i> Sign In
        </button>
    </div>

    <div class="text-center">
        <p class="mb-2">
            <a href="#" class="text-decoration-none">Forgot your password?</a>
        </p>
        <p class="mb-0">
            Don't have an account? 
            <a href="{{ route('customer.register') }}" class="text-decoration-none fw-bold">Sign up here</a>
        </p>
    </div>
</form>
@endsection

@section('footer-text')
    <a href="{{ url('/') }}" class="text-white-50 text-decoration-none">
        <i class="bi bi-arrow-left"></i> Back to home
    </a>
@endsection