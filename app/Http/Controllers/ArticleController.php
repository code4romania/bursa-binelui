<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Articles\ArticleCardResource;
use App\Http\Resources\Articles\ArticleResource;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Public/Articles/Articles', [
            'categories' => $this->getArticleCategories(),
            'collection' => ArticleCardResource::collection(
                Article::query()
                    ->orderByDesc('id')
                    ->wherePublished()
                    ->paginate(5)
            ),
            'topArticles' => ArticleCardResource::collection(
                Article::query()
                    ->wherePublished()
                    ->inRandomOrder()
                    ->limit(3)
                    ->get())
        ]);
    }

    public function category(ArticleCategory $category, Request $request): Response
    {
        return Inertia::render('Public/Articles/Articles', [
            'category' => $category->only('name', 'slug'),
            'categories' => $this->getArticleCategories(),
            'collection' => ArticleCardResource::collection(
                Article::query()
                    ->whereBelongsTo($category, 'category')
                    ->wherePublished()
                    ->orderByDesc('id')
                    ->paginate(5)
            ),
        ]);
    }

    public function show(Article $article): Response
    {
        return Inertia::render('Public/Articles/Show', [
            'resource' => ArticleResource::make($article),
            'related' =>  ArticleCardResource::collection(Article::query()
                ->wherePublished()
                ->whereBelongsTo($article->category, 'category')
                ->whereNot('id', $article->id)
                ->inRandomOrder()
                ->limit(3)
                ->get()),
        ]);
    }
}
