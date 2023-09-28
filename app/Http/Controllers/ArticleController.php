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
                    ->wherePublished()
                    ->paginate(5)
            ),
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
                    ->paginate(5)
            ),
        ]);
    }

    public function show(Article $article): Response
    {
        return Inertia::render('Public/Articles/Show', [
            'resource' => ArticleResource::make($article),
            'related' => [], /*  Article::query()
                ->wherePublished()
                ->whereBelongsTo('category', $article->category)
                ->whereNot('id', $article->id)
                ->inRandomOrder()
                ->limit(3)
                ->get(), */
        ]);
    }
}
