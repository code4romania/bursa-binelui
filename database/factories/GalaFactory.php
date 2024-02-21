<?php

namespace Database\Factories;

use App\Models\County;
use App\Models\Gala;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gala>
 */
class GalaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(255),
            'start_date' => fake()->date('Y-m-d'),
            'end_date' => fake()->date('Y-m-d'),
            'start_sign_up' => fake()->date('Y-m-d'),
            'end_sign_up' => fake()->date('Y-m-d'),
            'start_validate' => fake()->date('Y-m-d'),
            'end_validate' => fake()->date('Y-m-d'),
            'start_evaluation' => fake()->date('Y-m-d'),
            'end_evaluation' => fake()->date('Y-m-d'),
            'start_gale' => fake()->date('Y-m-d'),
            'location' => fake()->text(255)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Gala $gala) {

            $gala->counties()->attach(
                County::query()
                    ->inRandomOrder()
                    ->take(fake()->numberBetween(1, 3))
                    ->get()
            );
        });
    }
}
