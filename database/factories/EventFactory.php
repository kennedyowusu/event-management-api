<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date' => $this->faker->dateTime,
            'time' => $this->faker->time,
            'venue' => $this->faker->address,
            'organizer_id' => User::factory(),
            'capacity' => $this->faker->numberBetween(10, 100),
        ];
    }

    /**
     * Indicate that the event has tickets.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withTickets(int $count)
    {
        return $this->has(Ticket::factory()->count($count), 'tickets');
    }

    /**
     * Indicate that the event has reviews.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withReviews(int $count)
    {
        return $this->has(Review::factory()->count($count), 'reviews');
    }
}
