@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
    <h1 class="h2">Profile Settings</h1>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Profile Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person"></i>
                    Profile Information
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="form-text text-warning">
                                <i class="bi bi-exclamation-triangle"></i>
                                Your email address is unverified.
                                <button form="send-verification" class="btn btn-link p-0 text-decoration-none">
                                    Click here to re-send the verification email.
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i>
                            Save Changes
                        </button>
                    </div>
                </form>

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-none">
                        @csrf
                    </form>
                @endif
            </div>
        </div>

        <!-- Change Password -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-key"></i>
                    Change Password
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                               id="password_confirmation" name="password_confirmation" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-shield-check"></i>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle"></i>
                    Delete Account
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    Once your account is deleted, all of its resources and data will be permanently deleted. 
                    Before deleting your account, please download any data or information that you wish to retain.
                </p>
                
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="bi bi-trash"></i>
                    Delete Account
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Account Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle"></i>
                    Account Summary
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-5"><strong>Member Since:</strong></div>
                    <div class="col-7">{{ $user->created_at->format('M Y') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><strong>Total Tickets:</strong></div>
                    <div class="col-7">{{ $user->tickets()->count() }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5"><strong>Email Status:</strong></div>
                    <div class="col-7">
                        @if($user->hasVerifiedEmail())
                            <span class="badge bg-success">Verified</span>
                        @else
                            <span class="badge bg-warning">Unverified</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Tips -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-shield-check"></i>
                    Security Tips
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check text-success"></i>
                        <small>Use a strong, unique password</small>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success"></i>
                        <small>Keep your email address current</small>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success"></i>
                        <small>Verify your email address</small>
                    </li>
                    <li class="mb-0">
                        <i class="bi bi-check text-success"></i>
                        <small>Log out from shared devices</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAccountModalLabel">
                    <i class="bi bi-exclamation-triangle"></i>
                    Confirm Account Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                <p class="text-danger"><strong>All your tickets and data will be permanently deleted.</strong></p>
                
                <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')

                    <div class="mb-3">
                        <label for="delete_password" class="form-label">Please enter your password to confirm:</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="delete_password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                    <i class="bi bi-trash"></i>
                    Delete Account
                </button>
            </div>
        </div>
    </div>
</div>
@endsection