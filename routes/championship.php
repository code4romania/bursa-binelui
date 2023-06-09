<?php

declare(strict_types=1);

use App\Http\Controllers\ChampionshipController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('campionatul-de-bine', [ChampionshipController::class, 'index'])->name('championship');
Route::get('editia/{year}', [ChampionshipController::class, 'edition'])->name('edition');

/* Ong routes. */
Route::prefix('ong')->middleware('auth')->group(function () {});
