<?php

namespace Database\Factories;

use App\Models\Edition;
use App\Models\EditionCategories;
use App\Models\EditionFaq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Edition>
 */
class EditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(),
            'short_description' => fake()->text(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Edition $edition) {
            EditionCategories::factory()
                ->count(2)
                ->for($edition)
                ->create();

            EditionFaq::factory()
                ->count(5)
                ->for($edition)
                ->create();
        });
    }
}
