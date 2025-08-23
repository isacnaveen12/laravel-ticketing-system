@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
    <h1 class="h2">My Tickets</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            New Ticket
        </a>
    </div>
</div>
@endsection

@section('content')
<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('tickets.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Search tickets...">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Statuses</option>
                    @foreach(\App\Models\Ticket::getStatuses() as $value => $label)
                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="priority" class="form-label">Priority</label>
                <select class="form-select" id="priority" name="priority">
                    <option value="">All Priorities</option>
                    @foreach(\App\Models\Ticket::getPriorities() as $value => $label)
                        <option value="{{ $value }}" {{ request('priority') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
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
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tickets Table -->
<div class="card">
    <div class="card-body">
        @if($tickets->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'title', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-dark">
                                    Title
                                    @if(request('sort_by') == 'title')
                                        <i class="bi bi-chevron-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Category</th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'status', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-dark">
                                    Status
                                    @if(request('sort_by') == 'status')
                                        <i class="bi bi-chevron-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'priority', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-dark">
                                    Priority
                                    @if(request('sort_by') == 'priority')
                                        <i class="bi bi-chevron-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-dark">
                                    Created
                                    @if(request('sort_by') == 'created_at')
                                        <i class="bi bi-chevron-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
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
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-decoration-none fw-semibold">
                                    {{ Str::limit($ticket->title, 60) }}
                                </a>
                            </td>
                            <td>{{ $ticket->category->name }}</td>
                            <td>
                                <span class="badge bg-{{ $ticket->status_color }} status-badge">
                                    {{ $ticket->status_label }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $ticket->priority_color }} priority-badge">
                                    {{ $ticket->priority_label }}
                                </span>
                            </td>
                            <td>{{ $ticket->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tickets.show', $ticket) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($ticket->status == 'open')
                                        <a href="{{ route('tickets.edit', $ticket) }}" 
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-ticket-perforated text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">No Tickets Found</h4>
                <p class="text-muted">
                    @if(request()->hasAny(['search', 'status', 'priority', 'category']))
                        Try adjusting your search criteria or 
                        <a href="{{ route('tickets.index') }}" class="text-decoration-none">clear filters</a>.
                    @else
                        Create your first support ticket to get started.
                    @endif
                </p>
                <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    Create Ticket
                </a>
            </div>
        @endif
    </div>
</div>
@endsection