<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'user_id', 'ticket_type', 'price', 'booking_date', 'payment_status'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isUnpaid(): bool
    {
        return $this->payment_status === 'unpaid';
    }

    public function totalAmount(): float
    {
        return $this->price;
    }

    public function ticketType(): string
    {
        return $this->ticket_type;
    }

    public function bookingDate(): string
    {
        return $this->booking_date;
    }

    public function paymentStatus(): string
    {
        return $this->payment_status;
    }
}
