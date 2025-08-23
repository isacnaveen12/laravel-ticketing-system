@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            New Ticket
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Tickets</h5>
                        <h2 class="mb-0">{{ $stats['total_tickets'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-ticket-perforated" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Open Tickets</h5>
                        <h2 class="mb-0">{{ $stats['open_tickets'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-exclamation-circle" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">In Progress</h5>
                        <h2 class="mb-0">{{ $stats['in_progress_tickets'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-hourglass-split" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Resolved</h5>
                        <h2 class="mb-0">{{ $stats['resolved_tickets'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Tickets -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Tickets</h5>
                <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
            <div class="card-body">
                @if($recent_tickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_tickets as $ticket)
                                <tr>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-decoration-none">
                                            {{ Str::limit($ticket->title, 50) }}
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
                                    <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-ticket-perforated text-muted" style="font-size: 3rem;"></i>
                        <h5 class="text-muted mt-3">No Tickets Yet</h5>
                        <p class="text-muted">Create your first support ticket to get started.</p>
                        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Create Ticket
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection