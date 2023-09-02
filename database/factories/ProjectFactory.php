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
        $name = $this->faker->name;

        $start = CarbonImmutable::createFromInterface(
            fake()->dateTimeBetween('-3 days', 'today')
        );

        $end = $start->addDays(7);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text,
            'status' => $this->faker->randomElement(ProjectStatus::values()),
            'target_budget' => $this->faker->numberBetween(1000, 1000000),
            'scope' => $this->faker->text,
            'reason_to_donate' => $this->faker->text,
            'beneficiaries' => $this->faker->text,
            'start' => $start,
            'end' => $end,
            'accepting_volunteers' => $this->faker->boolean,
            'accepting_comments' => $this->faker->boolean,
            'videos' => $this->faker->randomElements(['https://www.youtube.com/watch?v=9bZkp7q19f0', 'https://www.youtube.com/watch?v=2Vv-BfVoq4g', 'https://www.youtube.com/watch?v=JGwWNGJdvx8'], 2),
            'external_links' => $this->faker->randomElements(['https://www.facebook.com/Asociatia-Comunitara-Cluj-Napoca-107374190771664', 'https://www.facebook.com/Asociatia-Comunitara-Cluj-Napoca-107374190771664'], 2),

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
