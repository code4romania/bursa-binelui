<?php

declare(strict_types=1);

use App\Http\Controllers\Dashboard\GalaProjectController;
use App\Http\Controllers\GalaController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('gale-regionale', [GalaController::class, 'index'])->name('regional');
Route::get('regional-editia/{year}', [GalaController::class, 'edition'])->name('regional.edition.year');
Route::get('proiect-gale/{project:slug}', [GalaProjectController::class, 'show'])->name('regional.project');
Route::get('reguli-gale-regionale/{page:slug}', PageController::class)->name('regional.rules');
Route::get('/regional/{gala:id}', [GalaController::class, 'gala'])->name('regional.galas.show');
