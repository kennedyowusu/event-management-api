<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::all();
        return response()->json($reviews, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $review = Review::where('event_id', $request->event_id)->where('user_id', Auth::id())->first();

        if ($review) {
            return response()->json(['error' => 'You have already reviewed this event'], 403);
        } else {
            $request->validate([
                'event_id' => 'required|exists:events,id',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string',
            ]);

            $review = Review::create([
                'event_id' => $request->event_id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            return response()->json([
                'status' => 'success',
                'review' => $review,
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review = Review::findOrFail($review->id);
        return response()->json($review, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $review = Review::findOrFail($review->id);

        if ($review->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        } else {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string',
            ]);

            $review->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            return response()->json($review, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review = Review::findOrFail($review->id);

        if ($review->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        } else {
            $review->delete();
            return response()->json(null, 204);
        }
    }

    // Get all reviews for a specific event
    public function eventReviews($event_id)
    {
        $reviews = Review::where('event_id', $event_id)->get();
        return response()->json($reviews, 200);
    }
}
