<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'venue',
        'organizer_id',
        'capacity',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }

    public function isAttendee(User $user): bool
    {
        return $this->attendees->contains($user);
    }

    public function hasReachedCapacity(): bool
    {
        return $this->attendees->count() >= $this->capacity;
    }

    public function ticketsRemaining(): int
    {
        return $this->capacity - $this->attendees->count();
    }

    public function ticketsSold(): int
    {
        return $this->attendees->count();
    }

    public function hasTicket(User $user): bool
    {
        return $this->tickets->contains('user_id', $user->id);
    }

    public function ticketFor(User $user)
    {
        return $this->tickets->firstWhere('user_id', $user->id);
    }

    public function averageRating(): float
    {
        return $this->reviews->avg('rating');
    }

    public function hasReview(User $user): bool
    {
        return $this->reviews->contains('user_id', $user->id);
    }

    public function reviewFor(User $user)
    {
        return $this->reviews->firstWhere('user_id', $user->id);
    }
}
