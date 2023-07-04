<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        // $query = Article::query();

        $categories = ArticleCategory::whereHas('articles', function ($query) {
            $query->where('is_active', true);
        })->get();

        $articles = Article::active()->with('category');
        if ($request->get('category')) {
            $category = $categories->search(function (ArticleCategory $item) use  ($request) {
                return $item['slug'] == $request->get('category');
            });
            $articles = $articles->where('article_category_id', $category);
        }
        $articles = $articles->paginate(10);

        return Inertia::render('Public/Articles/Articles', [
            'categories' => $categories,
            'query' => $articles,
        ]);
    }

    public function article(Article $article)
    {
        $article->load('category');
        $gallery = $article->getMedia('gallery');
//dd($article->relatedArticles()->get());
        return Inertia::render('Public/Articles/Article', [
            'article' => $article,
            'gallery' => $gallery,
            'related' => $article->relatedArticles()->get(),
        ]);
    }
}
