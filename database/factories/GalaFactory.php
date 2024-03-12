<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\County;
use App\Models\Gala;
use Carbon\Carbon;
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
        $date = Carbon::createFromInterface(fake()->dateTimeBetween('-1 week', '5 weeks'));

        return [
            'title' => fake()->text(25),
            'start_date' => $date,
            'end_date' => $date->addDays(7),
            'start_sign_up' => $date,
            'end_sign_up' => $date->addDays(7),
            'start_validate' => $date->addDays(14),
            'end_validate' => $date->addDays(21),
            'start_evaluation' => $date->addDays(28),
            'end_evaluation' => $date->addDays(35),
            'start_gale' => $date->addDays(42),
            'location' => fake()->text(255),
        ];
    }

    public function configure(): Factory|self
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
