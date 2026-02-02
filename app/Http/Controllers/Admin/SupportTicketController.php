<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\BusinessConfiguration;
use App\Models\TicketComment;
use App\Models\TicketHistory;
use App\Models\TicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::with(['businessConfiguration', 'creator']);

        if ($request->filled('client_id')) {
            $query->where('bus_config_id', $request->client_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $tickets = $query->latest()->paginate(10);
        $clients = BusinessConfiguration::select('bus_config_id', 'bus_name')->get();

        return view('admin.support_tickets.index', compact('tickets', 'clients'));
    }

    public function create()
    {
        $clients = BusinessConfiguration::select('bus_config_id', 'bus_name')->get();
        return view('admin.support_tickets.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'client_id' => 'required|exists:business_configurations,bus_config_id',
            'priority' => 'required|in:informational,new_feature,medium,critical',
            'status' => 'required|in:pending,in_progress,resolved',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $ticket = SupportTicket::create([
                    'title' => $request->title,
                    'bus_config_id' => $request->client_id,
                    'priority' => $request->priority,
                    'status' => $request->status,
                    'description' => $request->description,
                    'created_by' => Auth::id() ?? 1,
                ]);

                TicketHistory::create([
                    'ticket_id' => $ticket->id,
                    'action' => 'Ticket created',
                    'performer_id' => Auth::id() ?? 1,
                    'performer_type' => get_class(Auth::user() ?? new \App\Models\Admin()),
                ]);

                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $path = $file->store('ticket_attachments', 'public');
                        TicketAttachment::create([
                            'ticket_id' => $ticket->id,
                            'file_path' => $path,
                            'file_name' => $file->getClientOriginalName(),
                            'file_type' => $file->getClientMimeType(),
                        ]);
                    }
                }
            });

            return redirect()->route('admin.support_tickets.index')->with('success', 'Ticket created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating ticket: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $decryptedId = \Illuminate\Support\Facades\Crypt::decryptString($id);
        } catch (\Exception $e) {
            $decryptedId = $id;
        }
        
        $ticket = SupportTicket::with(['businessConfiguration', 'creator', 'comments.commenter', 'attachments', 'history.performer'])->findOrFail($decryptedId);
        return view('admin.support_tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $decryptedId = \Illuminate\Support\Facades\Crypt::decryptString($id);
        } catch (\Exception $e) {
            $decryptedId = $id;
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved'
        ]);

        try {
            DB::transaction(function () use ($decryptedId, $request) {
                $ticket = SupportTicket::findOrFail($decryptedId);
                $oldStatus = $ticket->status;
                $ticket->update(['status' => $request->status]);

                if ($oldStatus !== $request->status) {
                    TicketHistory::create([
                        'ticket_id' => $ticket->id,
                        'action' => "Status changed from " . ucfirst(str_replace('_', ' ', $oldStatus)) . " to " . ucfirst(str_replace('_', ' ', $request->status)),
                        'performer_id' => Auth::id(),
                        'performer_type' => get_class(Auth::user()),
                    ]);
                }
            });

            return back()->with('success', 'Status updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }

    public function addComment(Request $request, $id)
    {
        try {
            $decryptedId = \Illuminate\Support\Facades\Crypt::decryptString($id);
        } catch (\Exception $e) {
            $decryptedId = $id;
        }

        $request->validate([
            'comment' => 'required|string'
        ]);

        try {
            DB::transaction(function () use ($decryptedId, $request) {
                $ticket = SupportTicket::findOrFail($decryptedId);

                TicketComment::create([
                    'ticket_id' => $ticket->id,
                    'comment' => $request->comment,
                    'commenter_id' => Auth::id(),
                    'commenter_type' => get_class(Auth::user()),
                ]);
            });

            return back()->with('success', 'Comment added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error adding comment: ' . $e->getMessage());
        }
    }
}
