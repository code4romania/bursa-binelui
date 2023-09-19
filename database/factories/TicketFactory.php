<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Ticket;
use App\Models\TicketMessage;
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
            'user_id' => User::factory(),
            'organization_id' => Organization::factory(),
            'subject' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'closed_at' => fake()->boolean() ? now() : null,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Ticket $ticket) {
            $organizationAdmin = $ticket->organization
                ->users
                ->first();

            $superAdmin = User::query()
                ->onlySuperAdmins()
                ->first();

            TicketMessage::factory()
                ->for($ticket)
                ->recycle($organizationAdmin)
                ->count(fake()->randomDigitNotNull())
                ->create();

            TicketMessage::factory()
                ->for($ticket)
                ->recycle($superAdmin)
                ->count(fake()->randomDigitNotNull())
                ->create();
        });
    }
}
