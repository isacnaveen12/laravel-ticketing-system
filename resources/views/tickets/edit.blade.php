@extends('layouts.app')

@section('title', 'Edit Ticket #' . $ticket->id)
@section('page-title', 'Edit Ticket #' . $ticket->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Ticket</h5>
            </div>
            <div class="card-body">
                @if($ticket->status !== 'open')
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        This ticket can only be edited while it has an "Open" status.
                    </div>
                @else
                    <form method="POST" action="{{ route('tickets.update', $ticket) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $ticket->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" name="priority" required>
                                    <option value="">Select Priority</option>
                                    <option value="low" {{ old('priority', $ticket->priority) === 'low' ? 'selected' : '' }}>
                                        Low - General inquiry
                                    </option>
                                    <option value="medium" {{ old('priority', $ticket->priority) === 'medium' ? 'selected' : '' }}>
                                        Medium - Standard issue
                                    </option>
                                    <option value="high" {{ old('priority', $ticket->priority) === 'high' ? 'selected' : '' }}>
                                        High - Important issue
                                    </option>
                                    <option value="critical" {{ old('priority', $ticket->priority) === 'critical' ? 'selected' : '' }}>
                                        Critical - System down/urgent
                                    </option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="6" required>{{ old('description', $ticket->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($ticket->attachments->count() > 0)
                            <div class="mb-4">
                                <h6>Current Attachments:</h6>
                                <div class="row">
                                    @foreach($ticket->attachments as $attachment)
                                        <div class="col-md-6 mb-2">
                                            <div class="border rounded p-2 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-file-earmark text-primary me-2"></i>
                                                    <span class="fw-semibold">{{ $attachment->original_name }}</span>
                                                    <small class="text-muted d-block">{{ $attachment->formatted_size }}</small>
                                                </div>
                                                <a href="{{ route('tickets.download', [$ticket, $attachment]) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted">Note: File attachments cannot be modified after ticket creation.</small>
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="bi bi-info-circle me-2"></i>Important:</h6>
                            <ul class="mb-0">
                                <li>Only open tickets can be edited</li>
                                <li>File attachments cannot be modified after creation</li>
                                <li>Changes will be logged in the ticket history</li>
                                <li>Support team will be notified of any changes</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Back to Ticket
                            </a>
                            <button type="submit" class="btn btn-gradient-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Update Ticket
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection