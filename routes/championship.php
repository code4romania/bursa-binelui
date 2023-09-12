<?php

declare(strict_types=1);

use App\Http\Controllers\ChampionshipController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('campionatul-de-bine', [ChampionshipController::class, 'index'])->name('championship');
Route::get('editia/{year}', [ChampionshipController::class, 'edition'])->name('edition');

Route::get('projects', [ChampionshipController::class, 'projects'])->name('infinite_projects');
Route::post('project/subscribe-project', [ChampionshipController::class, 'subscribeProject'])->name('championship.subscribe.project');
Route::get('reguli-campionatul-de-bine', [ChampionshipController::class, 'championshipRules'])->name('championship.rules');
