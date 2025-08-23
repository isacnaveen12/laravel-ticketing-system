@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
    <h1 class="h2">Ticket #{{ $ticket->id }} - {{ Str::limit($ticket->title, 50) }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @if($ticket->status == 'open')
            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-primary me-2">
                <i class="bi bi-pencil"></i>
                Edit
            </a>
        @endif
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
        <!-- Ticket Details -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $ticket->title }}</h5>
                <div>
                    <span class="badge bg-{{ $ticket->status_color }} me-2">{{ $ticket->status_label }}</span>
                    <span class="badge bg-{{ $ticket->priority_color }}">{{ $ticket->priority_label }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Description:</strong>
                </div>
                <div class="mb-3 p-3 bg-light rounded">
                    {{ $ticket->description }}
                </div>
                
                @if($ticket->attachments->count() > 0)
                    <div class="mb-3">
                        <strong>Attachments:</strong>
                    </div>
                    <div class="row">
                        @foreach($ticket->attachments as $attachment)
                            <div class="col-md-6 mb-2">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-paperclip text-muted"></i>
                                                <span class="ms-1">{{ Str::limit($attachment->original_name, 30) }}</span>
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
                @endif
            </div>
        </div>

        <!-- Conversation Thread -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-chat-dots"></i>
                    Conversation
                </h5>
            </div>
            <div class="card-body">
                @if($ticket->replies->count() > 0)
                    @foreach($ticket->replies as $reply)
                        <div class="mb-3 p-3 border rounded {{ $reply->user_id == auth()->id() ? 'bg-primary bg-opacity-10 border-primary' : 'bg-light' }}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong>{{ $reply->user->name }}</strong>
                                    @if($reply->user_id == auth()->id())
                                        <span class="badge bg-primary">You</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $reply->created_at->format('M d, Y H:i') }}</small>
                            </div>
                            <div>{{ $reply->message }}</div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3 text-muted">
                        <i class="bi bi-chat-dots" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">No replies yet. Start the conversation below.</p>
                    </div>
                @endif

                <!-- Reply Form -->
                @if($ticket->status != 'closed')
                    <hr>
                    <form method="POST" action="{{ route('tickets.replies.store', $ticket) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="message" class="form-label">Add a Reply</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="4" required 
                                      placeholder="Type your message here...">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i>
                                Send Reply
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        This ticket is closed. No further replies can be added.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Ticket Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle"></i>
                    Ticket Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-4"><strong>Status:</strong></div>
                    <div class="col-8">
                        <span class="badge bg-{{ $ticket->status_color }}">{{ $ticket->status_label }}</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><strong>Priority:</strong></div>
                    <div class="col-8">
                        <span class="badge bg-{{ $ticket->priority_color }}">{{ $ticket->priority_label }}</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><strong>Category:</strong></div>
                    <div class="col-8">{{ $ticket->category->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4"><strong>Created:</strong></div>
                    <div class="col-8">{{ $ticket->created_at->format('M d, Y H:i') }}</div>
                </div>
                <div class="row">
                    <div class="col-4"><strong>Updated:</strong></div>
                    <div class="col-8">{{ $ticket->updated_at->format('M d, Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-clock-history"></i>
                    Activity Timeline
                </h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item mb-3">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Ticket Created</h6>
                            <p class="mb-1">{{ $ticket->user->name }} created this ticket</p>
                            <small class="text-muted">{{ $ticket->created_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                    
                    @foreach($ticket->replies as $reply)
                        <div class="timeline-item mb-3">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Reply Added</h6>
                                <p class="mb-1">{{ $reply->user->name }} replied to this ticket</p>
                                <small class="text-muted">{{ $reply->created_at->format('M d, Y H:i') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    border-left: 3px solid #007bff;
}
</style>
@endpush