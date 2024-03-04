<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\EditionCategories;
use App\Models\Gala;
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
            ->whereHas('edition', fn ($query) => $query->where('active', true))
            ->inRandomOrder()
            ->first();
        $editionID = $gala->edition_id;
        $categories = EditionCategories::query()
            ->where('edition_id', $editionID)
            ->limit(2)
            ->get();

        $name = fake()->text('200');
        $slug = Str::slug($name);

        return [
            'edition_id' => $editionID,
            'gala_id' => $gala->id,
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->text('500'),
            'start_date' => fake()->date('Y-m-d'),
            'end_date' => fake()->date('Y-m-d'),
            'categories' => $categories->pluck('id'),
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
            'contact_name' => fake()->name(),
            'contact_position' => fake()->jobTitle(),
            'contact_phone_number' => fake()->phoneNumber(),
            'contact_email' => fake()->email(),
        ];
    }
}
