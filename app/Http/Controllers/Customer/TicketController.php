<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateTicketRequest;
use App\Http\Requests\Customer\AddCommentRequest;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the customer's tickets.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->tickets()->with(['category']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('subject', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('ticket_number', 'like', '%' . $request->search . '%');
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $tickets = $query->paginate(10);
        $categories = Category::active()->ordered()->get();

        return view('customer.tickets.index', compact('tickets', 'categories'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('customer.tickets.create', compact('categories'));
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(CreateTicketRequest $request)
    {
        $ticket = new Ticket($request->validated());
        $ticket->ticket_number = Ticket::generateTicketNumber();
        $ticket->user_id = Auth::id();
        $ticket->save();

        // Handle file attachments
        if ($request->hasFile('attachments')) {
            $this->handleAttachments($request->file('attachments'), $ticket);
        }

        return redirect()->route('customer.tickets.show', $ticket)
            ->with('success', 'Ticket created successfully! Ticket Number: ' . $ticket->ticket_number);
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        // Ensure the ticket belongs to the authenticated user
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $ticket->load(['category', 'comments.user', 'attachments']);
        
        return view('customer.tickets.show', compact('ticket'));
    }

    /**
     * Add a comment to the ticket.
     */
    public function addComment(AddCommentRequest $request, Ticket $ticket)
    {
        // Ensure the ticket belongs to the authenticated user
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $comment = new TicketComment($request->validated());
        $comment->ticket_id = $ticket->id;
        $comment->user_id = Auth::id();
        $comment->save();

        return redirect()->route('customer.tickets.show', $ticket)
            ->with('success', 'Comment added successfully!');
    }

    /**
     * Download an attachment.
     */
    public function downloadAttachment(TicketAttachment $attachment)
    {
        // Ensure the attachment belongs to a ticket owned by the authenticated user
        if ($attachment->ticket->user_id !== Auth::id()) {
            abort(403);
        }

        if (!Storage::exists($attachment->file_path)) {
            abort(404);
        }

        return Storage::download($attachment->file_path, $attachment->original_name);
    }

    /**
     * Handle file attachments for a ticket.
     */
    private function handleAttachments(array $files, Ticket $ticket): void
    {
        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $storedName = Str::random(40) . '.' . $extension;
            $filePath = $file->storeAs('ticket-attachments', $storedName, 'local');

            TicketAttachment::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'original_name' => $originalName,
                'stored_name' => $storedName,
                'file_path' => $filePath,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }
    }
}