<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'user_id', 'rating', 'comment'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rating(): int
    {
        return $this->rating;
    }

    public function comment(): string
    {
        return $this->comment;
    }

    public function user_id(): int
    {
        return $this->user_id;
    }

    public function event_id(): int
    {
        return $this->event_id;
    }
}
