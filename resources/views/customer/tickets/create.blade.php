@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
    <h1 class="h2">Create New Ticket</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to Tickets
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" name="priority" required>
                                    @foreach(\App\Models\Ticket::getPriorities() as $value => $label)
                                        <option value="{{ $value }}" {{ old('priority', 'medium') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="6" required 
                                  placeholder="Please describe your issue in detail...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="attachments" class="form-label">Attachments</label>
                        <input type="file" class="form-control @error('attachments.*') is-invalid @enderror" 
                               id="attachments" name="attachments[]" multiple 
                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt,.zip">
                        <div class="form-text">
                            Allowed file types: JPG, PNG, PDF, DOC, DOCX, TXT, ZIP. Max size: 10MB per file.
                        </div>
                        @error('attachments.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary me-md-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Create Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle"></i>
                    Tips for Creating Tickets
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check text-success"></i>
                        <strong>Be specific</strong> - Clear subject lines help us understand your issue quickly
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success"></i>
                        <strong>Add details</strong> - Include steps to reproduce, error messages, or screenshots
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check text-success"></i>
                        <strong>Choose the right priority</strong> - This helps us respond appropriately
                    </li>
                    <li class="mb-0">
                        <i class="bi bi-check text-success"></i>
                        <strong>Select correct category</strong> - This routes your ticket to the right team
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-clock"></i>
                    Response Times
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <div class="text-danger fw-bold">Critical</div>
                            <small class="text-muted">1 hour</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-warning fw-bold">High</div>
                        <small class="text-muted">4 hours</small>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <div class="text-info fw-bold">Medium</div>
                            <small class="text-muted">24 hours</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-success fw-bold">Low</div>
                        <small class="text-muted">48 hours</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // File input validation
    const fileInput = document.getElementById('attachments');
    const maxSize = 10 * 1024 * 1024; // 10MB in bytes
    
    fileInput.addEventListener('change', function() {
        const files = this.files;
        for (let i = 0; i < files.length; i++) {
            if (files[i].size > maxSize) {
                alert(`File "${files[i].name}" is too large. Maximum size is 10MB.`);
                this.value = '';
                return;
            }
        }
    });
});
</script>
@endpush