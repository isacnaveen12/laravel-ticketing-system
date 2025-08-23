@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Profile Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Profile Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-gradient-primary">
                            <i class="bi bi-check-circle me-2"></i>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Change Password</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password.update') }}">
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
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-shield-lock me-2"></i>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Danger Zone</h5>
            </div>
            <div class="card-body">
                <h6 class="text-danger">Delete Account</h6>
                <p class="text-muted">
                    Once you delete your account, all of your tickets and data will be permanently deleted. 
                    This action cannot be undone.
                </p>
                
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="bi bi-trash me-2"></i>
                    Delete Account
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Account Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Account Summary</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-person-circle text-white fs-1"></i>
                    </div>
                    <h5 class="mt-2">{{ Auth::user()->name }}</h5>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                </div>
                
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="fw-semibold">Member Since:</td>
                        <td>{{ Auth::user()->created_at->format('M j, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Total Tickets:</td>
                        <td>{{ Auth::user()->tickets()->count() }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Open Tickets:</td>
                        <td>{{ Auth::user()->tickets()->where('status', 'open')->count() }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Last Login:</td>
                        <td>{{ now()->format('M j, Y g:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-ticket-perforated me-2"></i>
                        My Tickets
                    </a>
                    <a href="{{ route('tickets.create') }}" class="btn btn-outline-success">
                        <i class="bi bi-plus-circle me-2"></i>
                        New Ticket
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Warning:</strong> This action cannot be undone!
                    </div>
                    
                    <p>All your tickets, replies, and account data will be permanently deleted.</p>
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">
                            Please enter your password to confirm:
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="delete_password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>
                        Delete My Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-borderless td {
        border: none;
        padding: 0.5rem 0;
    }
</style>
@endpush