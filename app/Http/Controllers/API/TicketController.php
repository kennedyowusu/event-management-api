<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ticket = Auth::user()->tickets;
        return response()->json($ticket, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket = Auth::user()->tickets()->where('id', $ticket->id)->first();
        return response()->json($ticket, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket = Auth::user()->tickets()->where('id', $ticket->id)->first();
        $ticket->delete();

        return response()->json(null, 204);
    }

    // Get all tickets for a specific event
    public function eventTickets($event_id)
    {
        $tickets = Ticket::where('event_id', $event_id)->get();
        return response()->json($tickets, 200);
    }

    public function attendEvent(Request $request, Event $event)
    {
        $request->validate([
            'ticket_type' => 'required|string',
            'price' => 'required|numeric',
            'payment_status' => 'required|string',
        ]);

        $existingTicket = Ticket::where('event_id', $event->id)
                                ->where('user_id', Auth::id())
                                ->first();

        if ($existingTicket) {
            return response()->json(['message' => 'You have already attended this event.'], 400);
        }

        $ticket = Ticket::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'ticket_type' => $request->ticket_type,
            'price' => $request->price,
            'booking_date' => now(),
            'payment_status' => $request->payment_status,
        ]);

        return response()->json($ticket, 201);
    }

    public function userAttendanceHistory()
    {
        $userTickets = Ticket::where('user_id', Auth::id())
                            ->with('event')
                            ->get();

        return response()->json($userTickets, 200);
    }


}
