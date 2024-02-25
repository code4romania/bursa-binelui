<?php

namespace Database\Factories;

use App\Models\EditionCategories;
use App\Models\Gala;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $editionID = $gala->edition_id;
        $categories = EditionCategories::query()
            ->where('edition_id', $editionID)
            ->limit(2)
            ->get();
//        dd($gala, $categories);
        return [
            'edition_id' => $editionID,
            'gala_id' => $gala->id,
            'title' => fake()->text('200'),
            'description' => fake()->text('500'),
            'start_date' => fake()->date('Y-m-d'),
            'end_date' => fake()->date('Y-m-d'),
            'categories' => json_encode($categories->map(fn (EditionCategories $category) => $category->id)),
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
