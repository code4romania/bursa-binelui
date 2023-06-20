<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ProjectCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $start =$this->faker->dateTimeBetween('today', 'next Monday +7 days');


        return [
            'name' => $name,
            'slug' => \Str::slug($name),
            'category' => $this->faker->randomElement(ProjectCategory::values()),
            'description' => $this->faker->text,
            'status'=> $this->faker->randomElement(['draft', 'published']),
            'target_budget' => $this->faker->numberBetween(1000, 100000),
            'scope' => $this->faker->text,
            'reason_to_donate' => $this->faker->text,
            'beneficiaries' => $this->faker->text,
            'start' => $start,
            'end' =>  $this->faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +2 days'),
            'accepting_volunteers' => $this->faker->boolean,
            'accepting_comments' => $this->faker->boolean,
            'videos' => $this->faker->randomElements(['https://www.youtube.com/watch?v=9bZkp7q19f0', 'https://www.youtube.com/watch?v=2Vv-BfVoq4g', 'https://www.youtube.com/watch?v=JGwWNGJdvx8'], 2),
            'external_links' => $this->faker->randomElements(['https://www.facebook.com/Asociatia-Comunitara-Cluj-Napoca-107374190771664', 'https://www.facebook.com/Asociatia-Comunitara-Cluj-Napoca-107374190771664'], 2),

        ];
    }
}
