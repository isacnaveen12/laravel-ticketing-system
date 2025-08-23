@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <h4 class="mb-0">
            <i class="bi bi-box-arrow-in-right"></i>
            Sign In
        </h4>
        <p class="mb-0 mt-2">Welcome back to {{ config('app.name') }}</p>
    </div>
    
    <div class="auth-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Sign In
                </button>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('register') }}" class="text-decoration-none">
                    Don't have an account? Sign up
                </a>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center mt-2">
                    <a href="{{ route('password.request') }}" class="text-decoration-none">
                        Forgot your password?
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection