<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\EditionCategories;
use App\Models\Prize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EditionCategories>
 */
class EditionCategoriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(25),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (EditionCategories $editionCategory) {
            Prize::factory()
                ->count(1)
                ->state(['edition_categories_id' => $editionCategory->id,
                    'edition_id' => $editionCategory->edition_id])
                ->create();
        });
    }
}
