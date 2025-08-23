@extends('customer.layouts.app')

@section('title', 'Ticket #' . $ticket->ticket_number)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-ticket-perforated"></i> Ticket #{{ $ticket->ticket_number }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('customer.tickets.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Tickets
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Ticket Details -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $ticket->subject }}</h5>
                <div>
                    <span class="badge bg-{{ $ticket->status_badge }} me-2">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                    <span class="badge bg-{{ $ticket->priority_badge }}">
                        {{ ucfirst($ticket->priority) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted">Category:</small><br>
                        <span class="badge rounded-pill" style="background-color: {{ $ticket->category->color }}; color: white;">
                            {{ $ticket->category->name }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Created:</small><br>
                        <strong>{{ $ticket->created_at->format('M j, Y \a\t g:i A') }}</strong>
                        <small class="text-muted">({{ $ticket->created_at->diffForHumans() }})</small>
                    </div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Description:</small>
                    <div class="mt-1 p-3 bg-light rounded">
                        {!! nl2br(e($ticket->description)) !!}
                    </div>
                </div>
                
                @if($ticket->attachments->count() > 0)
                <div class="mb-3">
                    <small class="text-muted">Attachments:</small>
                    <div class="row mt-2">
                        @foreach($ticket->attachments as $attachment)
                        <div class="col-md-6 col-lg-4 mb-2">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            @if($attachment->is_image)
                                                <i class="bi bi-image text-success" style="font-size: 1.5rem;"></i>
                                            @else
                                                <i class="bi bi-file-earmark text-primary" style="font-size: 1.5rem;"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="fw-bold d-block text-truncate">{{ $attachment->original_name }}</small>
                                            <small class="text-muted">{{ $attachment->formatted_size }}</small>
                                        </div>
                                        <div>
                                            <a href="{{ route('customer.tickets.attachment.download', $attachment) }}" 
                                               class="btn btn-outline-primary btn-sm" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Comments/Conversation -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-chat-dots"></i> Conversation 
                    <span class="badge bg-secondary">{{ $ticket->comments->count() }}</span>
                </h5>
            </div>
            <div class="card-body">
                @if($ticket->comments->count() > 0)
                    <div class="conversation">
                        @foreach($ticket->comments as $comment)
                        <div class="comment mb-3 p-3 
                            @if($comment->user_id === $ticket->user_id) 
                                bg-primary bg-opacity-10 border-start border-primary border-4
                            @else 
                                bg-success bg-opacity-10 border-start border-success border-4
                            @endif rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        @if($comment->user_id === $ticket->user_id)
                                            <i class="bi bi-person-circle text-primary" style="font-size: 1.5rem;"></i>
                                        @else
                                            <i class="bi bi-headset text-success" style="font-size: 1.5rem;"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <strong>
                                            @if($comment->user_id === $ticket->user_id)
                                                {{ $comment->user->name }} (You)
                                            @else
                                                {{ $comment->user->name }} (Support Agent)
                                            @endif
                                        </strong>
                                        <small class="text-muted d-block">
                                            {{ $comment->created_at->format('M j, Y \a\t g:i A') }}
                                            ({{ $comment->created_at->diffForHumans() }})
                                        </small>
                                    </div>
                                </div>
                                @if($comment->user_id === $ticket->user_id)
                                    <span class="badge bg-primary">Customer</span>
                                @else
                                    <span class="badge bg-success">Agent</span>
                                @endif
                            </div>
                            <div class="comment-content">
                                {!! nl2br(e($comment->comment)) !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-chat-dots text-muted" style="font-size: 3rem;"></i>
                        <h6 class="text-muted mt-2">No comments yet</h6>
                        <p class="text-muted">Start the conversation by adding a comment below.</p>
                    </div>
                @endif
                
                @if($ticket->status !== 'closed')
                <!-- Add Comment Form -->
                <hr>
                <h6><i class="bi bi-plus-circle"></i> Add Comment</h6>
                <form method="POST" action="{{ route('customer.tickets.comment', $ticket) }}" id="commentForm">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control @error('comment') is-invalid @enderror" 
                                  name="comment" rows="4" required 
                                  placeholder="Type your comment or question here...">{{ old('comment') }}</textarea>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Be specific about any new issues or questions. Our support team will respond soon.
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" id="commentBtn">
                            <i class="bi bi-send"></i> Add Comment
                        </button>
                    </div>
                </form>
                @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    This ticket is closed. If you need further assistance, please create a new ticket.
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Ticket Information -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle"></i> Ticket Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label small text-muted">Status</label>
                        <div class="status-timeline">
                            <div class="timeline-item {{ in_array($ticket->status, ['open', 'in_progress', 'resolved', 'closed']) ? 'active' : '' }}">
                                <i class="bi bi-circle-fill"></i> Open
                            </div>
                            <div class="timeline-item {{ in_array($ticket->status, ['in_progress', 'resolved', 'closed']) ? 'active' : '' }}">
                                <i class="bi bi-circle-fill"></i> In Progress
                            </div>
                            <div class="timeline-item {{ in_array($ticket->status, ['resolved', 'closed']) ? 'active' : '' }}">
                                <i class="bi bi-circle-fill"></i> Resolved
                            </div>
                            <div class="timeline-item {{ $ticket->status === 'closed' ? 'active' : '' }}">
                                <i class="bi bi-circle-fill"></i> Closed
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <label class="form-label small text-muted">Priority</label>
                        <div>
                            <span class="badge bg-{{ $ticket->priority_badge }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label small text-muted">Category</label>
                        <div>
                            <span class="badge rounded-pill" style="background-color: {{ $ticket->category->color }}; color: white;">
                                {{ $ticket->category->name }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-12 mb-2">
                        <label class="form-label small text-muted">Created</label>
                        <div class="fw-bold">{{ $ticket->created_at->format('M j, Y \a\t g:i A') }}</div>
                        <small class="text-muted">{{ $ticket->created_at->diffForHumans() }}</small>
                    </div>
                    
                    @if($ticket->resolved_at)
                    <div class="col-12 mb-2">
                        <label class="form-label small text-muted">Resolved</label>
                        <div class="fw-bold">{{ $ticket->resolved_at->format('M j, Y \a\t g:i A') }}</div>
                        <small class="text-muted">{{ $ticket->resolved_at->diffForHumans() }}</small>
                    </div>
                    @endif
                    
                    @if($ticket->closed_at)
                    <div class="col-12 mb-2">
                        <label class="form-label small text-muted">Closed</label>
                        <div class="fw-bold">{{ $ticket->closed_at->format('M j, Y \a\t g:i A') }}</div>
                        <small class="text-muted">{{ $ticket->closed_at->diffForHumans() }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-lightning"></i> Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('customer.tickets.create') }}" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Create New Ticket
                    </a>
                    <a href="{{ route('customer.tickets.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-list-ul"></i> View All Tickets
                    </a>
                    @if($ticket->status === 'resolved')
                    <button class="btn btn-outline-success" disabled>
                        <i class="bi bi-check-circle"></i> Ticket Resolved
                    </button>
                    @endif
                </div>
                
                <hr>
                
                <h6 class="small text-muted">Need More Help?</h6>
                <p class="small text-muted">
                    If this ticket doesn't solve your issue, feel free to create a new ticket or contact our support team directly.
                </p>
                <div class="d-grid">
                    <a href="mailto:support@example.com" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-envelope"></i> Email Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .status-timeline {
        position: relative;
    }
    
    .timeline-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    .timeline-item.active {
        color: #198754;
        font-weight: 600;
    }
    
    .timeline-item i {
        margin-right: 8px;
        font-size: 0.5rem;
    }
    
    .timeline-item.active i {
        color: #198754;
    }
    
    .comment {
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .comment-content {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('commentForm');
    const submitBtn = document.getElementById('commentBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding Comment...';
            submitBtn.disabled = true;
        });
    }
    
    // Auto-scroll to latest comment
    const conversation = document.querySelector('.conversation');
    if (conversation) {
        const lastComment = conversation.lastElementChild;
        if (lastComment) {
            lastComment.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
    
    // Check for new comments every 30 seconds (in a real app, you'd use WebSockets)
    setInterval(function() {
        // You could implement AJAX polling here for real-time updates
        // For now, we'll just add a subtle indicator that the page could be refreshed
        const now = new Date();
        const lastUpdate = document.createElement('small');
        lastUpdate.className = 'text-muted position-fixed bottom-0 end-0 m-3';
        lastUpdate.innerHTML = 'Last updated: ' + now.toLocaleTimeString();
        lastUpdate.style.background = 'rgba(255,255,255,0.9)';
        lastUpdate.style.padding = '5px 10px';
        lastUpdate.style.borderRadius = '5px';
        lastUpdate.style.fontSize = '0.75rem';
        lastUpdate.style.zIndex = '1000';
        
        // Remove previous indicator
        const existing = document.querySelector('.last-update-indicator');
        if (existing) existing.remove();
        
        lastUpdate.classList.add('last-update-indicator');
        document.body.appendChild(lastUpdate);
        
        // Auto-remove after 3 seconds
        setTimeout(() => lastUpdate.remove(), 3000);
    }, 30000);
});
</script>
@endsection