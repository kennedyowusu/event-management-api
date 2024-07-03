<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\TicketController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [AuthController::class, 'getUserProfile']);

    Route::get('/events', [EventController::class, 'index']);
    Route::post('/events', [EventController::class, 'store']);
    Route::get('/events/{event}', [EventController::class, 'show']);
    Route::put('/events/{event}', [EventController::class, 'update']);
    Route::delete('/events/{event}', [EventController::class, 'destroy']);
    Route::get('/events/{event}/attendees', [EventController::class, 'attendees']);
    // http://url/api/events/1/attendees

    Route::get('/events/{event}/tickets', [EventController::class, 'eventTickets']);
    Route::get('/events/{event}/reviews', [EventController::class, 'eventReviews']);

    Route::post('/events/{event}/attend', [TicketController::class, 'attendEvent']);
    // Add this route to routes/api.php

    Route::get('/user/attendance-history', [TicketController::class, 'userAttendanceHistory']);
    // http://url/api/user/attendance-history

    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']);
    Route::get('/tickets/{ticket}/event', [TicketController::class, 'eventTickets']);
    // http://url/api/tickets/1/event

    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::get('/reviews/{review}', [ReviewController::class, 'show']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
    Route::get('/reviews/{review}/event', [ReviewController::class, 'eventReviews']);
    // http://localhost:8000/api/reviews/1/event
});
