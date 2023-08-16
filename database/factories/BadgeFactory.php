<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Lottery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Badge>
 */
class BadgeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => Lottery::odds(5, 7)
                ->winner(fn () => fake()->paragraph())
                ->loser(fn () => null),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Badge $badge) {
            $badge->users()->sync(
                User::query()
                    ->inRandomOrder()
                    ->limit(fake()->numberBetween(1, 5))
                    ->pluck('id')
            );
        });
    }
}
