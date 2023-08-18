<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleCategoryFactory extends Factory
{
    protected $model = ArticleCategory::class;

    public function definition(): array
    {
        $name = $this->faker->word;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'is_active' => $this->faker->boolean,
        ];
    }

    public function name(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }
}
