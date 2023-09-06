<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->numberBetween(20, 10_000);

        return [
            'organization_id' => Organization::factory(),
            'project_id' => Project::factory(),
            'uuid' => Str::orderedUuid(),
            'amount' => $amount,
            'charge_amount' => $amount,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'status' => 'TBD',
            'updated_without_correct_e_pid' => fake()->boolean(),
        ];
    }
}
