<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ProjectStatus;
use App\Models\Donation;
use App\Models\Project;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->sentence();

        $start = CarbonImmutable::createFromInterface(
            fake()->dateTimeBetween('-3 days', 'today')
        );

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->text(),
            'status' => fake()->randomElement(ProjectStatus::values()),
            'target_budget' => fake()->numberBetween(1_000, 1_000_000),
            'scope' => fake()->text(),
            'reason_to_donate' => fake()->text(),
            'beneficiaries' => fake()->text(),
            'start' => $start,
            'end' => $start->addDays(7),
            'accepting_volunteers' => fake()->boolean(),
            'accepting_comments' => fake()->boolean(),
            'videos' => fake()->randomElements([
                ['url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0'],
                ['url' => 'https://www.youtube.com/watch?v=2Vv-BfVoq4g'],
                ['url' => 'https://www.youtube.com/watch?v=JGwWNGJdvx8'],
            ], 2),
            'external_links' => [['title' => $this->faker->name, 'url' => $this->faker->url]],
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Project $project) {
            Donation::factory()
                ->for($project)
                ->recycle($project->organization)
                ->count(fake()->numberBetween(0, 15))
                ->create();
        });
    }
}
