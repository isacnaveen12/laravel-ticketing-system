@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
    <h1 class="h2">Edit Ticket #{{ $ticket->id }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Back to Ticket
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('tickets.update', $ticket) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="title" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $ticket->title) }}" required>
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
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id', $ticket->category_id) == $category->id ? 'selected' : '' }}>
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
                                        <option value="{{ $value }}" 
                                                {{ old('priority', $ticket->priority) == $value ? 'selected' : '' }}>
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
                                  placeholder="Please describe your issue in detail...">{{ old('description', $ticket->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="attachments" class="form-label">Add New Attachments</label>
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

                    @if($ticket->attachments->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">Current Attachments</label>
                            <div class="row">
                                @foreach($ticket->attachments as $attachment)
                                    <div class="col-md-6 mb-2">
                                        <div class="card">
                                            <div class="card-body p-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="bi bi-paperclip text-muted"></i>
                                                        <span class="ms-1">{{ Str::limit($attachment->original_name, 25) }}</span>
                                                        <br>
                                                        <small class="text-muted">{{ $attachment->file_size_formatted }}</small>
                                                    </div>
                                                    <a href="{{ route('attachments.download', $attachment) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-secondary me-md-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i>
                            Update Ticket
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
                    <i class="bi bi-exclamation-triangle"></i>
                    Important Notes
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <strong>Note:</strong> You can only edit tickets with "Open" status. Once a ticket is in progress or resolved, editing is not allowed.
                </div>
                
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-info-circle text-primary"></i>
                        <small>Editing a ticket will update its modification date</small>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-info-circle text-primary"></i>
                        <small>New attachments will be added to existing ones</small>
                    </li>
                    <li class="mb-0">
                        <i class="bi bi-info-circle text-primary"></i>
                        <small>Consider adding a reply instead if the issue has evolved</small>
                    </li>
                </ul>
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