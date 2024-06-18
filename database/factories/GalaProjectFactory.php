<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Gala;
use App\Models\GalaProject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GalaProject>
 */
class GalaProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gala = Gala::query()
            ->inRandomOrder()
            ->first();

        $name = fake()->text(200);
        $slug = Str::slug($name);

        return [
            'gala_id' => $gala->id,
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->text('500'),
            'start_date' => fake()->date('Y-m-d'),
            'end_date' => fake()->date('Y-m-d'),
            'youth' => fake()->boolean(),
            'organization_type' => fake()->randomElement(['big', 'little']),
            'reason' => fake()->text(500),
            'solution' => fake()->text(500),
            'project_details' => fake()->text(500),
            'special' => fake()->text(500),
            'results' => fake()->text(500),
            'proud' => fake()->text(500),
            'partnership' => fake()->boolean(),
            'partnership_details' => fake()->text(500),
            'budget_details' => fake()->text(500),
            'area' => fake()->text(255),
            'participants' => fake()->text(500),
            'team_details' => fake()->text(500),
            'contact' => [
                'name' => fake()->name(),
                'position' => fake()->jobTitle(),
                'phone_number' => fake()->phoneNumber(),
                'email' => fake()->email(),
            ],
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (GalaProject $galaProject) {
            $galaProject->categories()->attach(
                $galaProject->gala->edition->editionCategories
                    ->shuffle()
                    ->take(fake()->numberBetween(1, 3))
                    ->pluck('id')
            );
        });
    }
}
