@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->id)
@section('page-title', 'Ticket #' . $ticket->id . ' - ' . $ticket->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Ticket Details -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-1">{{ $ticket->title }}</h5>
                        <small class="text-muted">
                            Created {{ $ticket->created_at->format('M j, Y \a\t g:i A') }} • 
                            Last updated {{ $ticket->updated_at->diffForHumans() }}
                        </small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-{{ $ticket->status_color }} mb-2">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span><br>
                        <span class="badge badge-priority-{{ $ticket->priority }}">
                            {{ ucfirst($ticket->priority) }} Priority
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Category:</strong> 
                    <span class="badge bg-light text-dark">{{ $ticket->category->name }}</span>
                </div>
                
                <div class="border-start border-3 border-primary ps-3 mb-4" style="background-color: #f8f9fa; padding: 1rem; border-radius: 0 8px 8px 0;">
                    {!! nl2br(e($ticket->description)) !!}
                </div>

                @if($ticket->attachments->count() > 0)
                    <div class="mb-3">
                        <h6>Attachments:</h6>
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
                    </div>
                @endif

                @if($ticket->status === 'open')
                    <div class="mt-3">
                        <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-warning">
                            <i class="bi bi-pencil me-2"></i>
                            Edit Ticket
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Conversation Thread -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-chat-dots me-2"></i>
                    Conversation ({{ $ticket->replies->count() }} replies)
                </h6>
            </div>
            <div class="card-body">
                @forelse($ticket->replies as $reply)
                    <div class="border-start border-3 border-{{ $reply->user->id === $ticket->user_id ? 'primary' : 'success' }} ps-3 mb-3"
                         style="background-color: {{ $reply->user->id === $ticket->user_id ? '#f8f9fa' : '#f0f9ff' }}; padding: 1rem; border-radius: 0 8px 8px 0;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong>{{ $reply->user->name }}</strong>
                                @if($reply->user->id === $ticket->user_id)
                                    <span class="badge bg-primary ms-2">You</span>
                                @else
                                    <span class="badge bg-success ms-2">Support</span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $reply->created_at->format('M j, Y \a\t g:i A') }}</small>
                        </div>
                        <div>
                            {!! nl2br(e($reply->message)) !!}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-3">
                        <i class="bi bi-chat text-muted fs-1"></i>
                        <p class="text-muted mt-2">No replies yet. Start the conversation below!</p>
                    </div>
                @endforelse

                <!-- Add Reply Form -->
                @if(in_array($ticket->status, ['open', 'in_progress']))
                    <hr>
                    <h6>Add a Reply</h6>
                    <form method="POST" action="{{ route('tickets.reply', $ticket) }}">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      name="message" rows="4" 
                                      placeholder="Type your message here..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-gradient-primary">
                            <i class="bi bi-send me-2"></i>
                            Send Reply
                        </button>
                    </form>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        This ticket is {{ $ticket->status }}. No further replies can be added.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Ticket Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Ticket Summary</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="fw-semibold">Ticket ID:</td>
                        <td>#{{ $ticket->id }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Status:</td>
                        <td>
                            <span class="badge bg-{{ $ticket->status_color }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Priority:</td>
                        <td>
                            <span class="badge badge-priority-{{ $ticket->priority }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Category:</td>
                        <td>{{ $ticket->category->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Created:</td>
                        <td>{{ $ticket->created_at->format('M j, Y g:i A') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Last Updated:</td>
                        <td>{{ $ticket->updated_at->format('M j, Y g:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Navigation -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-list-ul me-2"></i>
                        All Tickets
                    </a>
                    @if($ticket->status === 'open')
                        <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-warning">
                            <i class="bi bi-pencil me-2"></i>
                            Edit Ticket
                        </a>
                    @endif
                    <a href="{{ route('tickets.create') }}" class="btn btn-outline-success">
                        <i class="bi bi-plus-circle me-2"></i>
                        New Ticket
                    </a>
                </div>
            </div>
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