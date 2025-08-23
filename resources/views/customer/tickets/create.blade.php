@extends('customer.layouts.app')

@section('title', 'Create New Ticket')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-plus-circle"></i> Create New Ticket
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('customer.tickets.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Tickets
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-pen"></i> Ticket Details
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('customer.tickets.store') }}" enctype="multipart/form-data" id="ticketForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" name="subject" value="{{ old('subject') }}" required 
                                   placeholder="Brief description of your issue">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                            <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                <option value="">Select Priority</option>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                                    Low - General question or request
                                </option>
                                <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>
                                    Medium - Standard issue
                                </option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                                    High - Important issue affecting work
                                </option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>
                                    Urgent - Critical issue blocking work
                                </option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                    @if($category->description)
                                        - {{ $category->description }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="8" required 
                                  placeholder="Please provide a detailed description of your issue, including any steps you've already tried and any error messages you've received.">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Be as specific as possible. Include error messages, screenshots, and steps to reproduce the issue.
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="attachments" class="form-label">Attachments (Optional)</label>
                        <div class="file-drop-zone" id="file-drop-zone">
                            <i class="bi bi-cloud-upload" style="font-size: 2rem; color: #6c757d;"></i>
                            <p class="mb-2"><strong>Drop files here or click to browse</strong></p>
                            <p class="text-muted small mb-0">
                                Maximum 5 files, 10MB each<br>
                                Supported: Images (JPG, PNG, GIF), Documents (PDF, DOC, DOCX, TXT), Archives (ZIP, RAR)
                            </p>
                            <input type="file" class="form-control @error('attachments.*') is-invalid @enderror" 
                                   id="attachments" name="attachments[]" multiple 
                                   accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip,.rar" 
                                   style="display: none;">
                        </div>
                        <div id="file-list" class="mt-3"></div>
                        @error('attachments.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('customer.tickets.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="bi bi-check-circle"></i> Create Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle"></i> Help & Tips
                </h5>
            </div>
            <div class="card-body">
                <h6>Writing a Good Ticket</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i>
                        <strong>Be specific:</strong> Clearly describe what you were trying to do
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i>
                        <strong>Include steps:</strong> List the steps that led to the issue
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i>
                        <strong>Add screenshots:</strong> Visual aids help us understand the problem
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i>
                        <strong>Error messages:</strong> Copy and paste any error messages
                    </li>
                </ul>
                
                <hr>
                
                <h6>Priority Guidelines</h6>
                <div class="small">
                    <div class="mb-2">
                        <span class="badge bg-success">Low</span>
                        General questions, feature requests
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-info">Medium</span>
                        Standard issues, minor bugs
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-warning">High</span>
                        Important issues affecting your work
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-danger">Urgent</span>
                        Critical issues blocking all work
                    </div>
                </div>
                
                <hr>
                
                <h6>Response Times</h6>
                <ul class="list-unstyled small text-muted">
                    <li><i class="bi bi-clock"></i> Low: 3-5 business days</li>
                    <li><i class="bi bi-clock"></i> Medium: 1-2 business days</li>
                    <li><i class="bi bi-clock"></i> High: 4-8 hours</li>
                    <li><i class="bi bi-clock"></i> Urgent: 1-2 hours</li>
                </ul>
            </div>
        </div>
        
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-question-circle"></i> Need Immediate Help?
                </h5>
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    For urgent issues that require immediate attention, please contact our emergency support line.
                </p>
                <div class="d-grid">
                    <a href="tel:+1234567890" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-telephone"></i> Emergency Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .file-drop-zone {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .file-drop-zone:hover {
        border-color: #007bff;
        background-color: #f8f9ff;
    }
    
    #ticketForm {
        position: relative;
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('ticketForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Form submission handling
    form.addEventListener('submit', function() {
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating Ticket...';
        submitBtn.disabled = true;
    });
    
    // Auto-resize description textarea
    const description = document.getElementById('description');
    description.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
    
    // Character counter for description
    const charCounter = document.createElement('div');
    charCounter.className = 'form-text text-end';
    charCounter.innerHTML = '0 characters';
    description.parentNode.appendChild(charCounter);
    
    description.addEventListener('input', function() {
        const length = this.value.length;
        charCounter.innerHTML = length + ' characters';
        
        if (length < 50) {
            charCounter.className = 'form-text text-end text-warning';
            charCounter.innerHTML += ' (provide more details for better support)';
        } else {
            charCounter.className = 'form-text text-end text-muted';
        }
    });
    
    // Priority change warning
    const priority = document.getElementById('priority');
    priority.addEventListener('change', function() {
        if (this.value === 'urgent') {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-warning alert-dismissible fade show mt-2';
            alertDiv.innerHTML = `
                <i class="bi bi-exclamation-triangle"></i>
                <strong>Urgent Priority Selected:</strong> 
                Please ensure this issue is truly urgent and blocking critical work. 
                For emergencies, consider calling our support line.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            priority.parentNode.appendChild(alertDiv);
            
            // Remove alert after 10 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 10000);
        }
    });
});
</script>
@endsection