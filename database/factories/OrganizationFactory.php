<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ActivityDomain;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->company(),
            'cif' => fake()->unixTime(),
            'description' => fake()->text(500),
            'street_address' => fake()->streetName(),
            'contact_person' => fake()->name(),
            'contact_phone' => fake()->phoneNumber(),
            'contact_email' => fake()->companyEmail(),
            'website' => fake()->url(),
            'accepts_volunteers' => fake()->boolean(),
            'why_volunteer' => fake()->text(333),
            'status' => fake()->randomElement(['pending', 'active', 'disabled']),
        ];
    }
}
