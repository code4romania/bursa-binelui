<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Make a donor user.
     */
    public function donor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'donor'
        ]);
    }

    /**
     * Make a NGO Admin user.
     */
    public function ngoAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'ngo-admin'
        ]);
    }

    /**
     * Make a BB Manager user.
     */
    public function bbManager(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'bb-manager'
        ]);
    }

    /**
     * Make a BB Admin user.
     */
    public function bbAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'bb-admin'
        ]);
    }
}
