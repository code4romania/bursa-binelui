<?php

declare(strict_types=1);

use App\Http\Controllers\PageController;
use App\Http\Controllers\RegionalController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('gale-regionale', [RegionalController::class, 'index'])->name('regional');
Route::get('regional-editia/{year}', [RegionalController::class, 'edition'])->name('regional.edition.year');
Route::get('proiect-gale/{project:slug}', [RegionalController::class, 'project'])->name('regional.project');
Route::get('reguli-gale-regionale/{page:slug}', PageController::class)->name('regional.rules');
Route::get('/regional/{gala:id}', [RegionalController::class, 'gala'])->name('regional.galas.show');
