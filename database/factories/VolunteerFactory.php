<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\VolunteerStatus;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

class VolunteerFactory extends Factory
{
    protected $model = Volunteer::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'status' => fake()->randomElement([
                VolunteerStatus::pending,
                VolunteerStatus::active,
                VolunteerStatus::inactive,
            ]),
        ];
    }
}
