<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get ticket statistics
        $totalTickets = $user->tickets()->count();
        $openTickets = $user->tickets()->where('status', 'open')->count();
        $inProgressTickets = $user->tickets()->where('status', 'in_progress')->count();
        $resolvedTickets = $user->tickets()->where('status', 'resolved')->count();
        
        // Get recent tickets
        $recentTickets = $user->tickets()
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalTickets',
            'openTickets', 
            'inProgressTickets',
            'resolvedTickets',
            'recentTickets'
        ));
    }
}