<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ArticleCategory;
use App\Models\Edition;
use App\Models\EditionCategories;
use App\Models\EditionFaq;
use App\Models\Gala;
use App\Models\Page;
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
            'title' => fake()->text(25),
            'short_description' => fake()->text(),
            'page_id' => Page::query()->inRandomOrder()->first()->id,
            'article_category_id' => ArticleCategory::query()->inRandomOrder()->first()->id,
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

            Gala::factory()
                ->count(5)
                ->for($edition)
                ->create();
        });
    }
}
