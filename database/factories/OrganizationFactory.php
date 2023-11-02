<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\OrganizationStatus;
use App\Enums\VolunteerStatus;
use App\Models\ActivityDomain;
use App\Models\County;
use App\Models\Organization;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Str;

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
        $name = fake()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'cif' => fake()->unixTime(),
            'description' => fake()->text(500),
            'address' => fake()->address(),
            'contact_person' => fake()->name(),
            'contact_phone' => fake()->phoneNumber(),
            'contact_email' => fake()->companyEmail(),
            'website' => fake()->url(),
            'accepts_volunteers' => fake()->boolean(),
            'why_volunteer' => fake()->text(333),

            'eu_platesc_merchant_id' => config('services.eu_platesc.merchant_id'),
            'eu_platesc_private_key' => config('services.eu_platesc.private_key'),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrganizationStatus::pending,
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrganizationStatus::approved,
            'status_updated_at' => fake()->dateTime(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrganizationStatus::rejected,
            'status_updated_at' => fake()->dateTime(),
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Organization $organization) {
            $organization->activityDomains()->attach(
                ActivityDomain::query()
                    ->inRandomOrder()
                    ->take(fake()->numberBetween(1, 3))
                    ->get()
            );

            $organization->counties()->attach(
                County::query()
                    ->inRandomOrder()
                    ->take(fake()->numberBetween(1, 3))
                    ->get()
            );

            $admin = User::factory()
                ->for($organization)
                ->organizationAdmin()
                ->state([
                    'email' => "admin-{$organization->id}@example.com",
                ])
                ->create();

            $managers = User::factory()
                ->count(3)
                ->for($organization)
                ->ngoManager()
                ->state(new Sequence(
                    ['email' => "manager-{$organization->id}@example.com"],
                    ['email' => "manager-{$organization->id}@example.org"],
                    ['email' => "manager-{$organization->id}@example.net"],
                ))
                ->create();

            if ($organization->isPending()) {
                return;
            }

            $projects = Project::factory()
                ->for($organization)
                ->count(2)
                ->hasAttached(
                    Volunteer::factory()
                        ->count(1),
                    fn () => [
                        'status' => fake()->randomElement(VolunteerStatus::cases()),
                    ]
                )
                ->hasAttached(
                    Volunteer::factory()
                        ->withUser()
                        ->count(2),
                    fn () => [
                        'status' => fake()->randomElement(VolunteerStatus::cases()),
                    ]
                )
                ->hasAttached(
                    ProjectCategory::query()
                        ->inRandomOrder()
                        ->take(fake()->numberBetween(1, 3))
                        ->get(),
                    relationship:'categories'
                )
                ->create();

            $ticket = Ticket::factory()
                ->for($organization)
                ->for($admin)
                ->create();

            $organization->volunteers()->attach(
                Volunteer::factory()
                    ->count(1)
                    ->create(),
                ['status' => VolunteerStatus::PENDING]
            );

            $organization->volunteers()->attach(
                Volunteer::factory()
                    ->count(1)
                    ->withUser()
                    ->create(),
                ['status' => VolunteerStatus::PENDING]
            );
        });
    }
}
