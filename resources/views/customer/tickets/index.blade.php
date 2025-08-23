@extends('customer.layouts.app')

@section('title', 'My Tickets')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-ticket-perforated"></i> My Tickets
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('customer.tickets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New Ticket
        </a>
    </div>
</div>

<!-- Filters -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('customer.tickets.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Ticket number, subject...">
            </div>
            
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label for="priority" class="form-label">Priority</label>
                <select class="form-select" id="priority" name="priority">
                    <option value="">All Priorities</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <label for="sort" class="form-label">Sort By</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                    <option value="subject" {{ request('sort') == 'subject' ? 'selected' : '' }}>Subject</option>
                    <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>Priority</option>
                    <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Status</option>
                </select>
                <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('customer.tickets.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tickets List -->
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            Tickets ({{ $tickets->total() }})
        </h5>
        <div class="btn-group btn-group-sm" role="group">
            <input type="radio" class="btn-check" name="view" id="list-view" autocomplete="off" checked>
            <label class="btn btn-outline-secondary" for="list-view">
                <i class="bi bi-list"></i>
            </label>
            <input type="radio" class="btn-check" name="view" id="card-view" autocomplete="off">
            <label class="btn btn-outline-secondary" for="card-view">
                <i class="bi bi-grid"></i>
            </label>
        </div>
    </div>
    
    <div class="card-body p-0">
        @if($tickets->count() > 0)
            <!-- List View -->
            <div id="list-view-content">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <a href="{{ route('customer.tickets.index', array_merge(request()->all(), ['sort' => 'ticket_number', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                                       class="text-decoration-none text-dark">
                                        Ticket # 
                                        @if(request('sort') == 'ticket_number')
                                            <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('customer.tickets.index', array_merge(request()->all(), ['sort' => 'subject', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                                       class="text-decoration-none text-dark">
                                        Subject
                                        @if(request('sort') == 'subject')
                                            <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Category</th>
                                <th>
                                    <a href="{{ route('customer.tickets.index', array_merge(request()->all(), ['sort' => 'status', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                                       class="text-decoration-none text-dark">
                                        Status
                                        @if(request('sort') == 'status')
                                            <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('customer.tickets.index', array_merge(request()->all(), ['sort' => 'priority', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                                       class="text-decoration-none text-dark">
                                        Priority
                                        @if(request('sort') == 'priority')
                                            <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('customer.tickets.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                                       class="text-decoration-none text-dark">
                                        Created
                                        @if(request('sort', 'created_at') == 'created_at')
                                            <i class="bi bi-arrow-{{ request('direction', 'desc') == 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                            <tr>
                                <td>
                                    <strong class="text-primary">{{ $ticket->ticket_number }}</strong>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 250px;">
                                        <strong>{{ $ticket->subject }}</strong>
                                    </div>
                                    <small class="text-muted d-block">
                                        {{ Str::limit($ticket->description, 80) }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge rounded-pill" style="background-color: {{ $ticket->category->color }}; color: white;">
                                        {{ $ticket->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $ticket->status_badge }} status-badge">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $ticket->priority_badge }} priority-badge">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $ticket->created_at->format('M j, Y') }}<br>
                                        {{ $ticket->created_at->format('g:i A') }}
                                    </small>
                                </td>
                                <td>
                                    <a href="{{ route('customer.tickets.show', $ticket) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Card View -->
            <div id="card-view-content" style="display: none;">
                <div class="row p-3">
                    @foreach($tickets as $ticket)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 ticket-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <small class="text-primary fw-bold">{{ $ticket->ticket_number }}</small>
                                <span class="badge bg-{{ $ticket->status_badge }} status-badge">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">{{ $ticket->subject }}</h6>
                                <p class="card-text text-muted small">
                                    {{ Str::limit($ticket->description, 100) }}
                                </p>
                                <div class="mb-2">
                                    <span class="badge rounded-pill" style="background-color: {{ $ticket->category->color }}; color: white;">
                                        {{ $ticket->category->name }}
                                    </span>
                                    <span class="badge bg-{{ $ticket->priority_badge }} priority-badge">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    Created {{ $ticket->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('customer.tickets.show', $ticket) }}" 
                                   class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-ticket-perforated text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">No tickets found</h4>
                <p class="text-muted">
                    @if(request()->hasAny(['search', 'status', 'priority', 'category']))
                        Try adjusting your filters or <a href="{{ route('customer.tickets.index') }}">clear all filters</a>
                    @else
                        Create your first support ticket to get started
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'status', 'priority', 'category']))
                    <a href="{{ route('customer.tickets.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Create Your First Ticket
                    </a>
                @endif
            </div>
        @endif
    </div>
    
    @if($tickets->hasPages())
        <div class="card-footer bg-white">
            {{ $tickets->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View toggle functionality
    const listViewBtn = document.getElementById('list-view');
    const cardViewBtn = document.getElementById('card-view');
    const listViewContent = document.getElementById('list-view-content');
    const cardViewContent = document.getElementById('card-view-content');
    
    listViewBtn.addEventListener('change', function() {
        if (this.checked) {
            listViewContent.style.display = 'block';
            cardViewContent.style.display = 'none';
        }
    });
    
    cardViewBtn.addEventListener('change', function() {
        if (this.checked) {
            listViewContent.style.display = 'none';
            cardViewContent.style.display = 'block';
        }
    });
});
</script>
@endsection