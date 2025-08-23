@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <!-- Statistics Cards -->
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="stat-number">{{ $totalTickets }}</div>
            <h5 class="text-muted mb-0">Total Tickets</h5>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="stat-number text-primary">{{ $openTickets }}</div>
            <h5 class="text-muted mb-0">Open Tickets</h5>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="stat-number text-warning">{{ $inProgressTickets }}</div>
            <h5 class="text-muted mb-0">In Progress</h5>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="stat-number text-success">{{ $resolvedTickets }}</div>
            <h5 class="text-muted mb-0">Resolved</h5>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Recent Tickets -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Tickets</h5>
                <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentTickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTickets as $ticket)
                                <tr>
                                    <td><strong>#{{ $ticket->id }}</strong></td>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-decoration-none">
                                            {{ Str::limit($ticket->title, 30) }}
                                        </a>
                                    </td>
                                    <td>{{ $ticket->category->name }}</td>
                                    <td>
                                        <span class="badge badge-priority-{{ $ticket->priority }}">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->status_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($ticket->status === 'open')
                                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-ticket-perforated fs-1 text-muted"></i>
                        <h5 class="text-muted mt-2">No tickets yet</h5>
                        <p class="text-muted">Create your first support ticket to get started.</p>
                        <a href="{{ route('tickets.create') }}" class="btn btn-gradient-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Create Ticket
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('tickets.create') }}" class="btn btn-gradient-primary">
                        <i class="bi bi-plus-circle me-2"></i>
                        Create New Ticket
                    </a>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-list-ul me-2"></i>
                        View All Tickets
                    </a>
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-person me-2"></i>
                        Manage Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Help -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Need Help?</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Our support team is here to help you with any questions or issues.</p>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-clock text-primary me-2"></i>
                        <small>Response time: 24-48 hours</small>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-shield-check text-success me-2"></i>
                        <small>All communications are secure</small>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-people text-info me-2"></i>
                        <small>Dedicated support team</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        border-top: none;
        font-weight: 600;
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.025);
    }
</style>
@endpush