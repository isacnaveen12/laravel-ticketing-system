@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="navbar-brand fs-1">{{ config('app.name') }}</h2>
                        <p class="text-muted">Create your account</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" 
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-gradient-primary btn-lg">
                                Create Account
                            </button>
                        </div>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0">Already have an account?</p>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Sign In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection