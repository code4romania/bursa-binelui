<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\UserRole;
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
            'newsletter' => fake()->boolean()
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
            'role' => UserRole::USER,
        ]);
    }

    /**
     * Make a NGO Admin user.
     */
    public function organizationAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::ADMIN,
        ]);
    }

    /**
     * Make a NGO Manager user.
     */
    public function ngoManager(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::MANAGER,
        ]);
    }

    /**
     * Make a BB Manager user.
     */
    public function superManager(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::SUPERMANAGER,
        ]);
    }

    /**
     * Make a BB Admin user.
     */
    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::SUPERADMIN,
        ]);
    }
}
