<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
            'ticket_type' => $this->faker->randomElement(['VIP', 'Regular']),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'booking_date' => $this->faker->dateTime,
            'payment_status' => $this->faker->randomElement(['Paid', 'Pending']),
        ];
    }
}
