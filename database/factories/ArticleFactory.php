<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => collect(fake()->paragraphs(10))
                ->map(fn (string $paragraph) => "<p>{$paragraph}</p>")
                ->implode(''),
            'published_at' => fake()->boolean(95) ? fake()->dateTimeThisYear() : null,
            'author' => fake()->name(),
            'article_category_id' => ArticleCategory::factory(),
        ];
    }
}
