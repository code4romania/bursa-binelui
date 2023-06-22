<?php

declare(strict_types=1);

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('articole', [ArticleController::class, 'index'])->name('articles');
Route::get('articol/{id}', [ArticleController::class, 'article'])->name('article');

