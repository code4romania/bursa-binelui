<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = $this->faker->sentence;
        return [
            'title' => $title,
            'slug' => \Str::slug($title),
            'content' => $this->faker->paragraph,
            'is_active' => $this->faker->boolean,
            'author' => $this->faker->name,
            'article_category_id' => ArticleCategoryFactory::new(),
        ];
    }
}
