<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller
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
     * Display a listing of the tickets.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Auth::user()->tickets()->with(['category'])->withCount('replies');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $tickets = $query->paginate(10)->appends($request->query());

        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    /**
     * Show the form for creating a new ticket.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $categories = Category::all();
        return view('tickets.create', compact('categories'));
    }

    /**
     * Store a newly created ticket in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:low,medium,high,critical',
            'attachments.*' => 'nullable|file|mimes:jpg,png,pdf,doc,docx,txt,zip|max:10240', // 10MB max
        ]);

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
            'status' => 'open',
        ]);

        // Handle file attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('ticket-attachments', $filename, 'local');

                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'filename' => $filename,
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket created successfully!');
    }

    /**
     * Display the specified ticket.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Ticket $ticket)
    {
        // Ensure user can only view their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to ticket.');
        }

        $ticket->load(['category', 'attachments', 'replies.user']);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified ticket.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Ticket $ticket)
    {
        // Ensure user can only edit their own tickets and only if they're open
        if ($ticket->user_id !== Auth::id() || $ticket->status !== 'open') {
            abort(403, 'Cannot edit this ticket.');
        }

        $categories = Category::all();
        return view('tickets.edit', compact('ticket', 'categories'));
    }

    /**
     * Update the specified ticket in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Ticket $ticket)
    {
        // Ensure user can only update their own tickets and only if they're open
        if ($ticket->user_id !== Auth::id() || $ticket->status !== 'open') {
            abort(403, 'Cannot update this ticket.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:low,medium,high,critical',
        ]);

        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully!');
    }

    /**
     * Add a reply to the ticket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reply(Request $request, Ticket $ticket)
    {
        // Ensure user can only reply to their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Cannot reply to this ticket.');
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Reply added successfully!');
    }

    /**
     * Download a ticket attachment.
     *
     * @param  \App\Models\Ticket  $ticket
     * @param  \App\Models\TicketAttachment  $attachment
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadAttachment(Ticket $ticket, TicketAttachment $attachment)
    {
        // Ensure user can only download attachments from their own tickets
        if ($ticket->user_id !== Auth::id() || $attachment->ticket_id !== $ticket->id) {
            abort(403, 'Cannot download this attachment.');
        }

        $filePath = storage_path('app/' . $attachment->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $attachment->original_name);
    }
}