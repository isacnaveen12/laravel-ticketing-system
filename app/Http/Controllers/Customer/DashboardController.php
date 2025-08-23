<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'total_tickets' => $user->tickets()->count(),
            'open_tickets' => $user->tickets()->where('status', 'open')->count(),
            'in_progress_tickets' => $user->tickets()->where('status', 'in_progress')->count(),
            'resolved_tickets' => $user->tickets()->where('status', 'resolved')->count(),
        ];

        $recent_tickets = $user->tickets()
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('customer.dashboard', compact('stats', 'recent_tickets'));
    }
}