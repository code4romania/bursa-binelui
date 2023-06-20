<?php

declare(strict_types=1);

use App\Http\Controllers\ChampionshipController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('campionatul-de-bine', [ChampionshipController::class, 'index'])->name('championship');
Route::get('editia/{year}', [ChampionshipController::class, 'edition'])->name('edition');

Route::get('projects', [ChampionshipController::class, 'projects'])->name('infinite_projects');

/* Ong routes. */
Route::prefix('ong')->middleware('auth')->group(function () {
});
