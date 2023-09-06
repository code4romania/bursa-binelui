<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

class VolunteerFactory extends Factory
{
    protected $model = Volunteer::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
        ];
    }

    public function withUser(): static
    {
        return $this->state(fn ($attributes) => [
            'user_id' => User::factory()
                ->donor()
                ->state([
                    'email' => $attributes['email'],
                ]),
        ]);
    }
}
