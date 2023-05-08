<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\County;

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
        /** Choose a random county. */
        $countyId = fake()->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 51, 52]);
        $cityId = County::find($countyId)->cities->random()->id;
        $activityDomains = fake()->words(10);

        return [
            'name' => fake()->company(),
            'cif' => fake()->unixTime(),
            'description' => fake()->text(500),
            'county_id' => $countyId,
            'city_id' => $cityId,
            'street_address' => fake()->streetName(),
            'contact_person' => fake()->name(),
            'contact_phone' => fake()->phoneNumber(),
            'contact_email' => fake()->companyEmail(),
            'website' => fake()->url(),
            'accepts_volunteers' => fake()->boolean(),
            'why_volunteer' => fake()->text(333),
            'activity_domains' => implode(',', fake()->randomElements($activityDomains, 3)),
            'status' => fake()->randomElement(['pending', 'active', 'disabled'])
        ];
    }
}
