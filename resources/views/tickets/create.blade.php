@extends('layouts.app')

@section('title', 'Create Ticket')
@section('page-title', 'Create New Ticket')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Submit a Support Request</h5>
            </div>
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
                        <div class="form-text">Provide a clear, descriptive subject for your issue.</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                            <select class="form-select @error('priority') is-invalid @enderror" 
                                    id="priority" name="priority" required>
                                <option value="">Select Priority</option>
                                <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>
                                    Low - General inquiry
                                </option>
                                <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>
                                    Medium - Standard issue
                                </option>
                                <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>
                                    High - Important issue
                                </option>
                                <option value="critical" {{ old('priority') === 'critical' ? 'selected' : '' }}>
                                    Critical - System down/urgent
                                </option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="6" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Please provide detailed information about your issue, including steps to reproduce if applicable.</div>
                    </div>

                    <div class="mb-4">
                        <label for="attachments" class="form-label">Attachments</label>
                        <input type="file" class="form-control @error('attachments.*') is-invalid @enderror" 
                               id="attachments" name="attachments[]" multiple 
                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt,.zip">
                        @error('attachments.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Upload relevant files (images, documents, logs). 
                            Supported formats: JPG, PNG, PDF, DOC, DOCX, TXT, ZIP. Max 10MB per file.
                        </div>
                        
                        <!-- File preview area -->
                        <div id="file-preview" class="mt-2"></div>
                    </div>

                    <div class="alert alert-info">
                        <h6 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Before submitting:</h6>
                        <ul class="mb-0">
                            <li>Make sure you've provided all necessary details</li>
                            <li>Check if your issue is already covered in our FAQ</li>
                            <li>Our support team will respond within 24-48 hours</li>
                            <li>You'll receive email notifications for any updates</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to Dashboard
                        </a>
                        <button type="submit" class="btn btn-gradient-primary">
                            <i class="bi bi-send me-2"></i>
                            Submit Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('attachments').addEventListener('change', function(e) {
    const previewArea = document.getElementById('file-preview');
    previewArea.innerHTML = '';
    
    if (e.target.files.length > 0) {
        const fileList = document.createElement('div');
        fileList.className = 'mt-2';
        
        Array.from(e.target.files).forEach(file => {
            const fileItem = document.createElement('div');
            fileItem.className = 'border rounded p-2 mb-2 d-flex justify-content-between align-items-center';
            fileItem.innerHTML = `
                <div>
                    <i class="bi bi-file-earmark text-primary me-2"></i>
                    <span class="fw-semibold">${file.name}</span>
                    <small class="text-muted ms-2">(${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                </div>
                <span class="badge bg-success">Ready to upload</span>
            `;
            fileList.appendChild(fileItem);
        });
        
        previewArea.appendChild(fileList);
    }
});
</script>
@endpush