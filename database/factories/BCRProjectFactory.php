<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\City;
use App\Models\ProjectCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BCRProject>
 */
class BCRProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city = City::query()
            ->inRandomOrder()
            ->first();
        $categoryId = ProjectCategory::query()
            ->inRandomOrder()
            ->first()
            ->id;

        $title = $this->faker->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'start_date' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 day'),
            'external_links' => [
                [
                    'title' => $this->faker->sentence(),
                    'link' => $this->faker->url(),
                ],
                [
                    'title' => $this->faker->sentence(),
                    'link' => $this->faker->url(),
                ],
            ],
            'facebook_link' => $this->faker->url(),
            'accepting_comments' => $this->faker->boolean(),
            'videos' => [
                [
                    'link' => $this->faker->url(),
                ],
                [
                    'link' => $this->faker->url(),
                ],
            ],
            'city_id' => $city->id,
            'county_id' => $city->county_id,
            'project_category_id' => $categoryId,
        ];
    }
}
