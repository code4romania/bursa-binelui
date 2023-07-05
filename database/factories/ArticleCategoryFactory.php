<?php

namespace Database\Factories;

use App\Models\ArticleCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleCategoryFactory extends Factory
{
    protected $model = ArticleCategory::class;

    public function definition(): array
    {
        $name = $this->faker->word;
        return [
            'name' => $name,
            'slug' => \Str::slug($name),
            'is_active' => $this->faker->boolean,
        ];
    }
}
