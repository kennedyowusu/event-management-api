<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $events = Event::with('attendees', 'tickets', 'reviews')->get();
        return response()->json($events, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'venue' => 'required|string',
            'capacity' => 'required|integer',
        ]);

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'venue' => $request->venue,
            'organizer_id' => Auth::id(),
            'capacity' => $request->capacity,
        ]);

        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event = Event::with(['tickets.user', 'tickets.event', 'reviews.user', 'reviews.event'])->findOrFail($event->id);
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
            'time' => 'sometimes|required|string',
            'venue' => 'sometimes|required|string',
            'capacity' => 'sometimes|required|integer',
        ]);

        $event = Event::findOrFail($event->id);
        $event->update($request->all());

        return response()->json($event, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully'], 204);
    }

    // Get all attendees for a specific event
    public function attendees(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $attendees = $event->attendees;
        return response()->json($attendees, 200);
    }

    // Get all tickets for a specific event
    public function eventTickets(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $tickets = $event->tickets;
        return response()->json($tickets, 200);
    }

    // Get all reviews for a specific event
    public function eventReviews(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $reviews = $event->reviews;
        return response()->json($reviews, 200);
    }
}
