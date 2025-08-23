@extends('customer.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-speedometer2"></i> Welcome back, {{ Auth::user()->name }}!
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('customer.tickets.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create New Ticket
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stats-card">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        <p class="mb-0">Total Tickets</p>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-ticket-perforated" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['open'] }}</h3>
                        <p class="mb-0">Open Tickets</p>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-exclamation-circle" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['in_progress'] }}</h3>
                        <p class="mb-0">In Progress</p>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card border-0" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $stats['resolved'] }}</h3>
                        <p class="mb-0">Resolved</p>
                    </div>
                    <div class="opacity-75">
                        <i class="bi bi-check-circle" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Tickets -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history"></i> Recent Tickets
                </h5>
                <a href="{{ route('customer.tickets.index') }}" class="btn btn-outline-primary btn-sm">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body p-0">
                @if($recentTickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Ticket #</th>
                                    <th>Subject</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTickets as $ticket)
                                <tr class="cursor-pointer" onclick="window.location='{{ route('customer.tickets.show', $ticket) }}'">
                                    <td>
                                        <strong class="text-primary">{{ $ticket->ticket_number }}</strong>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;">
                                            {{ $ticket->subject }}
                                        </div>
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-ticket-perforated text-muted" style="font-size: 3rem;"></i>
                        <h5 class="text-muted mt-3">No tickets yet</h5>
                        <p class="text-muted">Get started by creating your first support ticket</p>
                        <a href="{{ route('customer.tickets.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Create Your First Ticket
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-question-circle"></i> Quick Actions
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
                    <a href="{{ route('customer.tickets.index', ['status' => 'open']) }}" class="btn btn-outline-warning">
                        <i class="bi bi-exclamation-circle"></i> View Open Tickets
                    </a>
                </div>
                
                <hr>
                
                <h6><i class="bi bi-info-circle"></i> Support Information</h6>
                <ul class="list-unstyled small text-muted">
                    <li><i class="bi bi-clock"></i> Response time: 24-48 hours</li>
                    <li><i class="bi bi-envelope"></i> Email notifications enabled</li>
                    <li><i class="bi bi-shield-check"></i> Secure file uploads</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .cursor-pointer {
        cursor: pointer;
    }
    
    .cursor-pointer:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection