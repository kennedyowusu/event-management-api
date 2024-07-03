<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users
        $users = User::factory()->count(10)->create();

        // Create events and attach random users as attendees
        Event::factory()
            ->count(5)
            ->withTickets(5)
            ->withReviews(3)
            ->create()
            ->each(function ($event) use ($users) {
                $event->attendees()->attach(
                    $users->random(rand(1, 5))->pluck('id')->toArray()
                );
            });
    }
}
