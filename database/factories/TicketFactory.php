<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\UserRole;
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
            $ngoAdmin = $ticket->organization
                ->getAdministrators()
                ->first();

            $bbAdmin = User::query()
                ->role(UserRole::bb_admin)
                ->first();

            TicketMessage::factory()
                ->for($ticket)
                ->recycle($ngoAdmin)
                ->count(fake()->randomDigitNotNull())
                ->create();

            TicketMessage::factory()
                ->for($ticket)
                ->recycle($bbAdmin)
                ->count(fake()->randomDigitNotNull())
                ->create();
        });
    }
}
