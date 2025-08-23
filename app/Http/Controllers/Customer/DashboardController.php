<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get ticket statistics
        $stats = [
            'total' => $user->tickets()->count(),
            'open' => $user->tickets()->where('status', 'open')->count(),
            'in_progress' => $user->tickets()->where('status', 'in_progress')->count(),
            'resolved' => $user->tickets()->where('status', 'resolved')->count(),
            'closed' => $user->tickets()->where('status', 'closed')->count(),
        ];

        // Get recent tickets
        $recentTickets = $user->tickets()
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('customer.dashboard', compact('stats', 'recentTickets'));
    }
}